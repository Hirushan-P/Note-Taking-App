<template>
    <div class="noteCard" :class="{ completed: note.completed }">  <!-- apply completed class dynamically -->
        <div class="card-header">
            <div class="card-category">
                <span >
                    <h4 :class="categoryClass" >{{note.category}}</h4>  <!-- apply categoryClass dynamically -->
                </span>
            </div>
            <div class="card-actions">
                <input type="checkbox" @change="updateNoteStatus" v-model="note.completed">
                <button class="edit-button" @click="editNote"><i class="fas fa-edit"></i></button>
                <button class="delete-button" @click="deleteNote"><i class="fas fa-trash-alt"></i></button>
            </div>  
        </div>

        <div class="card-content">            
            <span :class="[note.completed ? 'completed' : '', 'noteText']">  <!-- apply completed class dynamically -->
                <h2>{{note.title}}</h2>
                <br>
                <div class="card-description"><p>{{note.description}}</p></div>
            </span>
        </div>

    </div>
</template>


<script>
export default {
    props: {
        note: {
            type: Object,
            required: true
        }
    },
    methods: {
        editNote() {
            this.$emit('edit', this.note);
        },
        deleteNote() {
            // console.log('Delete button clicked for note:', this.note.title);
            // emit a delete event with the note object
            this.$emit('delete', this.note);
        },
        async updateNoteStatus() {
            // emit an event to update note status in the parent component
            this.$emit('update-status', this.note);
        }
    },
    computed: {
        categoryClass() {  // apply completed class dynamically
            return {
                'other': this.note.category === 'Other',
                'work': this.note.category === 'Work',
                'personal': this.note.category === 'Personal'
            };
        }
    }
};
</script>


<style scoped>
.noteCard {
    background-color: #ffffff;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    width: 70%;
    max-width: 350px;
    margin-bottom: 35px;
    transition: transform 0.2s ease;
}

.noteCard:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 6px rgba(42, 152, 236, 0.231);
}

.card-header {
    top: 10px;
    right: 10px;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
}

.card-category h4 {
    font-size: 16px;
    font-weight: bold;
    margin-top: 0px;
    border-radius: 20px;
    padding: 10px;
}

.other {
    background-color: #b39ddbb0;
    color: #4527A0;
}

.work {
    background-color: #ffcc80b0;
    color: #e6631d;
}

.personal {
    background-color: #A5D6A7b0;
    color: #1B5E20;
}

.card-actions {
    display: flex;
    flex-direction: row;
    margin-top: -15px;
}

.card-actions input[type="checkbox"] {
    height: 18px;
    width: 18px;
    margin-right: 25px;
}

.card-actions button {
    background-color: transparent;
    border: none;
    cursor: pointer;
    font-size: 18px;
    color: #686868;
    margin-right: 15px;
}

.card-header button:hover, input[type="checkbox"]:hover {
    opacity: 0.7;
    transform: scale(1.1);
}

.noteCard h2 {
    text-align: left;
    font-size: 22px;
    font-weight: bold;
    margin-top: 5px;
    margin-bottom: 2px;
}

.card-description {
    width: 95%;
}

.noteCard p {
    margin-top: 5px;
    text-align: left;
    font-size: 14px;
}

.completed {
    text-decoration: line-through;
    color: #7b7b7b;
    background-color: #ccc;
}
</style>