<template>
    <div class="wrap">
        <h2 class="mb-5">
            {{$store.state.notePage.title}}
        </h2>

        <div class="row justify-content-center">
            <div class="col-sm-8">
                <h3 class="text-center">  {{$store.state.notePage.head}}</h3>
                <div class="form-group">
                    <label>Add Notes</label>
                    <input type="email" class="form-control" v-model="noteData" @keyup.prevent="createNote"
                           placeholder="What needs to be done?">

                </div>
                <div class="note-list-container">
                    <div class="note-list-box row" v-for="(note, i) in filteredNotes" :key="i+1">

                        <div class="note col-10  d-flex flex-row">
                            <div class="checkbox d-flex">
                                <input class="form-check-input" type="checkbox" @click="taskCompleted($event, note, i)"
                                       :value="note.status" :checked="note.status === 'completed'">
                            </div>
                            <div class="note-text" :class="{'doneText' : note.status === 'completed' }"> {{note.note}}
                            </div>
                        </div>
                        <div class="note-action col-2 text-right">
                            <button class="btn btn-danger" @click="deleteNote(note, i)">X</button>
                        </div>
                    </div>
                    <div class="note-footer row">
                        <div class="col-3">{{summery.active}} Item<span v-if="summery.active > 1">s</span> Left</div>
                        <div class="col-6 justify-content-center d-flex">
                            <a href="#" :class="{'active': filterBy === 'all'}" @click.prevent="filterBy = 'all'">All</a>
                            <a href="#" :class="{'active': filterBy === 'active'}" @click.prevent="filterBy = 'active'">Active</a>
                            <a href="#" :class="{'active': filterBy === 'completed'}"
                               @click.prevent="filterBy = 'completed'">Completed</a>
                        </div>
                        <div class="col-3" v-if="summery.completed > 0"><a href="#" class="text-danger"
                                                                           @click.prevent="clearCompletedNotes"> Clear
                            Completed</a></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import {getRequest, postRequest} from './../request';

    export default {
        name: "Campaign",
        data: function () {
            return {
                noteData: '',
                notes: [],
                filterBy: 'all'
            };
        },
        mounted() {
            this.getNotes();
        },
        computed: {
            summery() {
                let data = {
                    active: 0,
                    completed: 0
                };
                this.notes.forEach(item => {
                    if (item.status === 'active') {
                        data.active++;
                    } else {
                        data.completed++
                    }
                });
                return data;
            },
            filteredNotes() {
                if (this.filterBy === 'all') {
                    return this.notes;
                }
                return this.notes.filter(item => {
                    return item.status === this.filterBy;
                })
            }
        },
        methods: {
            createNote: async function (e) {
                if (e.which === 13) {
                    if (this.noteData) {
                        let note = await postRequest('add-note', {note: this.noteData}, true);
                        if (note) {
                            this.getNotes();
                            this.noteData = '';
                        }
                    }
                }
            },
            async taskCompleted(event, note, i) {
                note.status = (event.target.checked ? "completed" : "active");
                let update = await postRequest('update-note', note, true);
                if (update) {
                    this.notes[i].status = note.status;
                }
            },
            async deleteNote( note, i) {
                var confirmBox = webToast.confirm('Are You Sure ?');
                confirmBox.click(async ()=> {
                    let update = await postRequest('delete-note', note, true);
                    if (update) {
                        await this.getNotes();
                    }
                });
            },
            async clearCompletedNotes() {
                var confirmBox = webToast.confirm('Are You Sure ?');
                confirmBox.click(async ()=> {
                    let update = await postRequest('clear-completed-note', {}, true);
                    if (update) {
                        await this.getNotes();
                    }
                })


            },
            getNotes: async function () {
                this.notes = await getRequest('get-notes', true, true);
            }
        }
    }
</script>

<style lang="scss">

    .note-list-container {
        box-shadow: 0 9px 9px 4px rgba(0, 0, 0, .2);
        padding: 5px 15px;

       .note-list-box {
           margin-bottom: 5px;
           transition: all .5s;
           button{
               padding: 0 5px;
           }
           button,input{
               opacity: 0;
           }
           &:hover button, &:hover input{
               opacity: 1;
           }
           .note{
               .checkbox{
                   margin-top: 10px;
               }
               .note-text{
                   padding-left: 25px;
                   font-size: 18px;
               }
           }
       }
    }


    .doneText {
        text-decoration: line-through;
    }

    .note-footer {
        padding-top: 10px;
        border-top: 1px solid #d0cfcf;
        a{
            text-align: center;
            padding-right: 5px;
            text-decoration: none;
            outline-width: 0;
            border-width: 0;
        }
        a.active{
            color: #ca23c4;
            background: #e4e0e0;
            padding: 0 5px;
            margin-right: 5px;
        }
        &:hover{
            color: green
        }
    }


</style>
