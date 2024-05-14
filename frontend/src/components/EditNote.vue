<template>
    <div class="backdrop" @click.self="closeEditModal">  
        <div class="editNoteCard">
            <div :class="categoryClass">
                <br>
                <h2>Edit note</h2>
                <hr>
            </div>
            <br>
            <div class="editNoteForm">
                <div class="editNoteTitle">
                    <div class="editNoteTextField">
                        <label for="title">Title</label>
                        <input type="text" id="title" placeholder="Add title" v-model="editedNote.title" />
                    </div>
                    <div class="editNoteTextField">
                        <label for="category">Category</label>
                        <select id="category" v-model="editedNote.category">
                            <option value="" disabled>Select Category</option>
                            <option value="Personal">Personal</option>
                            <option value="Work">Work</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                </div>
                <div class="editNoteDescription">
                    <div class="editNoteTextField">
                        <label for="description">Description</label>
                        <textarea id="description" rows="5" placeholder="Add description (Optional)" v-model="editedNote.description" @input="updateRemainingCharacters"></textarea>
                        <p class="char-count">Remaining characters: {{ remainingCharacters }}</p>
                    </div>
                </div>
                <div class="editNoteButtons">
                    <button class="cancelButton" @click="closeEditModal">Cancel</button>
                    <button class="saveButton" @click="saveNote">Save</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            editedNote: {
                title: '',
                category: '',
                description: ''
            },
            maxDescriptionLength: 500,
            remainingCharacters: 0
        };
    },
    methods: {
        closeEditModal() {
            this.$emit("close");
        },
        saveNote() {
            // emit the edited note object to the parent component
            this.$emit('save', this.editedNote);
        },
        updateRemainingCharacters() {
            this.remainingCharacters = this.maxDescriptionLength - this.editedNote.description.length;
        }
    },
    props: {
        note: {
            type: Object,
            required: true
        }
    },
    watch: {
        note: {
            handler(newNote) {
                // update the editedNote object when the note prop changes
                this.editedNote = { ...newNote };
            },
            immediate: true // trigger the handler immediately when the component is mounted
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
.backdrop {
    top: 0;
    position: fixed;
    background: rgba(0, 0, 0, 0.5);
    width: 100%;
    height: 100%;
}

.editNoteCard {
    width: 70%;
    padding: 20px;
    margin: 110px auto;
    background: white;
    border-radius: 25px;
    max-width: 650px;
}

.other {
    background-color: #b39ddbb0;
    color: #4527A0;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.work {
    background-color: #ffcc80b0;
    color: #e6631d;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

.personal {
    background-color: #A5D6A7b0;
    color: #1B5E20;
    border-top-left-radius: 12px;
    border-top-right-radius: 12px;
}

h2 {
    margin-top: 0px;
    margin-bottom: 17px;
    text-align: center;
    font-size: 30px;
    font-weight: bold;
}

.editNoteForm {
    display: flex;
    flex-direction: column;
    gap: 20px;
    width: 100%;
}

.editNoteTitle,
.editNoteDescription {
    display: flex;
    flex-direction: row;
    gap: 25px;
    width: 95%;
    margin: 2.5%;
}

.editNoteButtons {
    display: flex;
    flex-direction: row;
    justify-content: flex-end;
    gap: 25px;
    width: 97.5%;
    margin-bottom: 10px;
}

.editNoteTextField {
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

.char-count {
    margin-top: 0px;
    text-align: right;
    font-size: 12px;
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

@media screen and (max-width: 650px) {
    .editNoteTitle,
    .editNoteDescription {
        gap: 20px;
        width: 100%;
        margin: 0%;
    }
    label {
        font-size: 14px;
        margin-top: 5px;
    }
    input {
        border-radius: 4px;
        font-size: 13px;
        height: 22px;
    }
    select{
        font-size: 13px;
        height: 33.5px;
    }
    textarea{
        font-size: 13px;
        height: 75px;
    }
    .cancelButton,
    .saveButton {
        margin-top: 5px;
        margin-bottom: -7px;
        width: 85px;
        height: 35px;
        font-size: 13px;
    }
}

</style>
