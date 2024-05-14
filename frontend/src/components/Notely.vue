<template>
  <div id="app">
    <div class="header">  <!-- header section -->
      <div class="topBar">
        <div class="searchBar">
          <div class="searchBox">
            <input type="text" placeholder="Search here" />
          </div>
            <button><i class="fa-solid fa-magnifying-glass fa-beat-fade"></i></button>
        </div>
        <div class="addNote" @click="toggleAddModal">
          <p><i class="fa-solid fa-plus" style="margin-right: 3px;"></i> Add note </p>
        </div>
      </div>
    </div>

    <div class="appBody">  <!-- body section -->
      <h3 class="appBody_title">Your notes</h3>
      <nav class="navbar">
        <a href="#" class="nav-item" :class="{ active: activeIndex === 0 }" @click="setActive(0)">All</a>
        <a href="#" class="nav-item" :class="{ active: activeIndex === 1 }" @click="setActive(1)">Personal</a>
        <a href="#" class="nav-item" :class="{ active: activeIndex === 2 }" @click="setActive(2)">Work</a>
        <a href="#" class="nav-item" :class="{ active: activeIndex === 3 }" @click="setActive(3)">Other</a>
      </nav>
      <hr>

      <div>
        <br><br>
        
        <div class="note-list">
          <!-- pass the note object to the NoteCard.vue -->
          <NoteCard v-for="(note, index) in notes.data" :key="index" :note="note" @update-status="updateNoteStatus" @delete="deleteNote" @edit="openEditNoteForm"/>
        </div>
        <!-- floating action buttons for create new note and scroll to top -->
        <div class="floating-new-btn">
          <i class="fa-solid fa-circle-plus fa-beat" @click="toggleAddModal"></i>
        </div>
        <div class="floating-up-btn">
          <i class="fa-solid fa-circle-up fa-beat" @click="scrollToTop"></i>
        </div>
      </div>
    </div>
    <!-- AddNote and EditNote components -->
    <AddNote v-if="showAddModal" @close="toggleAddModal"/>
    <EditNote :note="selectedNote" v-if="showEditNoteForm" @close="closeEditNoteForm" @save="saveEditedNote" />
  </div>
</template>

<script>
import AddNote from './AddNote.vue';
import EditNote from './EditNote.vue';
import NoteCard from './NoteCard.vue';

export default {
  name: 'App',
  components: {
    AddNote,
    EditNote,
    NoteCard
  },
  data() {
    return {
      activeIndex: 0,
      notes: [],
      showAddModal: false,
      showEditNoteForm: false,
      selectedNote: null
    };
  },
  methods: {
    setActive(index) {
      this.activeIndex = index;
    },
    scrollToTop() {
      window.scrollTo({
        top: 0,
        behavior: 'smooth' // smooth scrolling behavior
      });
    },
    toggleAddModal(){  //shwo add new note form
      this.showAddModal = !this.showAddModal
    },
    openEditNoteForm(note) {  // show edit note form
        this.selectedNote = note;
        this.showEditNoteForm = true;
    },
    closeEditNoteForm() {  //close edit note form
        this.selectedNote = null;
        this.showEditNoteForm = false;
    },

    async loadNotes() {  // read all notes
      try {
        const response = await fetch('http://127.0.0.1:8000/api/v1/notes'); // make a GET request using fetch
        if (!response.ok) {
          throw new Error('Failed to fetch notes');
        }
        const data = await response.json(); // extract JSON from the response
        this.notes = data; // update the notes array with the fetched data
      } catch (error) {
        console.error('Error fetching notes:', error);
      }
    },

    async deleteNote(note) {  // delete a note using note.id
      const id = note.id;
      const url = `http://127.0.0.1:8000/api/v1/notes/${id}`;

      try {
          const response = await fetch(url, {
              method: 'DELETE',  // use DELETE request
          });

          if (response.ok) {
              // remove the deleted note from the notes array
              this.notes.data = this.notes.data.filter(n => n.id !== id);
              // display success message
              alert(note.title + ' note deleted successfully');
          } else {
              throw new Error('Failed to delete note');
          }
      } catch (error) {
          console.error('Error deleting note:', error);
          // display error message
          alert('Failed to delete note');
      }
    },
    
    async updateNoteStatus(note) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/v1/notes/${note.id}`, {
          method: 'PATCH', // use PATCH method to update specific fields
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            completed: note.completed
          })
        });
        if (!response.ok) {
          throw new Error('Failed to update note status');
        }
        console.log('Note status updated successfully');
      } catch (error) {
        console.error('Error updating note status:', error);
      }
    },
    
    async saveEditedNote(editedNote) {
      try {
        const response = await fetch(`http://127.0.0.1:8000/api/v1/notes/${editedNote.id}`, {
          method: 'PATCH', // use PATCH method to update specific fields
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(editedNote) // send the edited note object as JSON string
        });
        
        if (!response.ok) {
          throw new Error('Failed to update note');
        }

        // update the note in the notes array with the edited values
        const updatedNoteIndex = this.notes.data.findIndex(note => note.id === editedNote.id);
        if (updatedNoteIndex !== -1) {
          this.$set(this.notes.data, updatedNoteIndex, editedNote);
        }

        alert('Note updated successfully!');
        this.showEditNoteForm = false; // close the edit form

      } catch (error) {
        console.error('Error updating note:', error);
        alert('Failed to update note!')
      }
    }
  },
  mounted() {  // reload notes
    this.loadNotes();
  }
};
</script>

<style>
#app {
    font-family: 'Avenir', Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-align: center;
    color: #2c3e50;
    background: rgba(233, 233, 233, 0.970);
    margin-top: 5px;
    margin-bottom: 5px;
}

.header{
    background-color: #fff;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.topBar{
    max-width: 1100px;
    display: flex;
    margin: 0 auto;
    justify-content: space-between;
    align-items: center;
    padding: 10px 10px;
}

.searchBar {
    width: 69%;
    display: flex;
    align-items: center;
    background-color: #f2f2f2;
    border-radius: 6px;
    padding: 5px 10px;
    height: 30px;
}

.searchBar input {
    border: none;
    outline: none;
    padding: 5px;
    font-size: 16px;
    background-color: #f2f2f2;
}

.searchBar button {
    border: none;
    background-color: transparent;
    cursor: pointer;
    margin-left: auto;
}

.searchBar button:hover {
    transform: scale(1.1);
}
.addNote{
    width: 22%;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: rgb(48, 176, 255);
    border-radius: 6px;
    padding: 5px 7px;
    height: 30px;
    transition: transform 0.2s ease;
}

.addNote p{
    font-size: 15px;
    font-weight: 600;
    color: white;
    text-align: center;
}

.addNote:hover{
    cursor: pointer;
    transform: scale(1.05);
    background-color: rgb(0, 146, 237);
}

.appBody {
    width: 80%;
    margin-left: 10%;
}

.appBody_title {
    text-align: left;
    font-size: 27px;
    margin-top: 35px;
    margin-bottom: 20px;
}

.navbar {
    width: 60%;
    padding: 5px;
    max-width: 555px;
    display: flex;
    justify-content: space-between;
}

.nav-item {
    color: #2c3e50;
    text-decoration: none;
    font-size: 18px;
    font-weight: 500;
    padding: 5px;
}

.nav-item:hover {
    color: rgb(28, 122, 198);
    font-weight: bold;
}

.nav-item.active {
    color: rgb(28, 122, 198);
    font-weight: bold;
}

.note-list {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    grid-gap: 10px;
    justify-items: center;
}

.floating-new-btn i {
  position: fixed;
  bottom: 75px;
  right: 15px;
  font-size: 40px;
  margin: 10px;
  border: none;
  color: rgb(48, 176, 255);
}

.floating-up-btn i {
  position: fixed;
  bottom: 10px;
  right: 15px;
  font-size: 40px;
  margin: 10px;
  color: rgb(48, 176, 255);
}

.floating-new-btn i:hover, .floating-up-btn i:hover {
  transform: scale(1.1);
  color: rgb(0, 146, 237);
}

@media screen and (max-width: 650px) {
    .appBody_title {
      font-size: 23px;
    }
    .navbar {
        width: 80%;
    }
    .nav-item {
        margin-right: 5%;
        font-size: 15px;
    }
}

</style>
