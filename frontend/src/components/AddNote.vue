<template>
    <div class="backdrop" @click.self="closeAddModal">
        <div class="addNoteCard">
            <h2>Add note</h2>
            <hr><br>
            <div class="newNoteForm">
                <div class="addNoteTitle">
                    <div class="newNoteTextField">
                        <label for="title">Title</label>
                        <input type="text" id="title" placeholder="Add title" v-model="title" />
                    </div>
                    <div class="newNoteTextField">
                        <label for="category">Category</label>
                        <select id="category" v-model="category">
                            <option value="" disabled selected>Select Category</option>
                            <option value="personal">Personal</option>
                            <option value="work">Work</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="addNoteDescription">
                    <div class="newNoteTextField">
                        <label for="description">Description</label>
                        <textarea id="description" rows="5" placeholder="Add description (Optional)" v-model="description"></textarea>
                    </div>
                </div>
                <div class="newNoteButtons">
                    <button class="cancelButton" @click="closeAddModal">Cancel</button>
                    <button class="saveButton" @click="addNote">Add</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data () {
        return {
            title: '',
            category: '',
            description: ''
        };
    },
    methods: {
        closeAddModal() {  // close add note form
            this.$emit("close");
        },
        async addNote() {  // send new note to the backend
            try {
                const response = await fetch('http://127.0.0.1:8000/api/v1/notes', {
                    method: 'POST',
                    headers: {'Content-Type': 'application/json'},
                    body: JSON.stringify({
                        title: this.title,
                        category: this.category,
                        description: this.description
                    })
                });

                if (!response.ok) {
                    throw new Error('Failed to add note');
                }

                const data = await response.json();
                console.log('New note added successfully:', data);
                // display a success message and reload the page
                alert('New note added successfully!');
                this.closeAddModal();
            } catch (error) {
                console.error('Error adding note:', error);
                alert('Failed to add note');
            }
        }
    }
};
</script>

<style scoped>
.backdrop {
    top: 0;
    position: fixed;
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
}

.addNoteCard {
    width: 70%;
    padding: 20px;
    margin: 110px auto;
    background: white;
    border-radius: 15px;
    max-width: 650px;
}

h2 {
    margin-top: 10px;
    margin-bottom: 10px;
    margin-left: 2px;
    text-align: left;
    font-size: 30px;
    font-weight: bold;
}

.newNoteForm {
    display: flex;
    flex-direction: column;
    gap: 40px;
}

.addNoteTitle,
.addNoteDescription {
    display: flex;
    flex-direction: row;
    gap: 25px;
    width: 100%;
}

.newNoteButtons {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    gap: 10px;
    width: 100%;
}

.newNoteTextField {
    flex: 1;
    display: flex;
    flex-direction: column;
    gap: 7px;
}

label {
    font-size: 17px;
    font-weight: bold;
    color: #383838;
    text-align: left;
}

input {
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    font-size: 14px;
    height: 30px;
}

select{
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    font-size: 14px;
    height: 42px;
}

textarea{
    background-color: #f2f2f2;
    border: 1px solid #ccc;
    border-radius: 4px;
    padding: 5px;
    font-size: 14px;
    height: 110px;
    resize: none;
}

.cancelButton {
    width: 100px;
    height: 40px;
    border: none;
    color: #797979;
    background: #e3e3e3;
    display: inline-block;
    font-size: 14px;
    border-radius: 20px;
    cursor: pointer;
}

.cancelButton:hover{
    background: #f44336;
    color: #f2f2f2;
}

.saveButton {
    background: rgb(40, 173, 255);
    width: 100px;
    height: 40px;
    border: none;
    color: white;
    display: inline-block;
    font-size: 14px;
    border-radius: 20px;
    cursor: pointer;
}

.saveButton:hover{
    background: rgb(20, 157, 242);
}
</style>
