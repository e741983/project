<template>
    <div class="container">
    <form @submit.prevent="addToDo()" name="myForm">
        <div class="form-group row">
            <label for="text" class="col-md-1 col-form-label text-md-left">To Do:</label>
            <div class="col-md-4">
                <textarea class="form-control pull-left" v-model="note.text" id="text" name="text" rows="5" placeholder="Add text here..." required autofocus></textarea>
            </div>
            
            <label for="date" class="col-md-1 col-form-label text-md-right">Date:</label>
            <div class="col-md-3">
                <input type="text" id="date" v-model="note.date" class="form-control" placeholder="">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>        
        </div>

        
    </form>

    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchToDo(pagination.prev_page_url)">Previous</a></li>
        <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page}}</a></li>
        <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item"><a class="page-link" href="#" @click="fetchToDo(pagination.next_page_url)">Next</a></li>
      </ul>
    </nav>
    <div class="table-responsive">
    <table class="table">
        <th>Mark</th>
        <th>Note</th>
        <th width="200px">Date</th>
        <th width="200px">Action</th>
        <tr v-for="note in notes" v-bind:key="note.id">
            <td><input @change="markAs($event, note.id)" type="checkbox" v-model="note.complete" value="1"></td>
            <td>{{note.text}}</td>
            <td>{{note.date}}</td>
            <td>
                <button @click="editToDo(note)" class="btn btn-info">Edit</button>                        
                <button @click="deleteToDo(note.id)" class="btn btn-danger">Delete</button>
            </td>
        </tr>
    </table>
    </div>
    </div>
</template>

<script>

    let csrf = document.querySelector('meta[name="csrf-token"]').getAttribute('content')
    export default {
        data() {
            return {
                notes: [],
                note: {
                    id: '',
                    text: '',
                    date: '',
                    complete: '',

                },
                to_do_id: '',
                pagination: {},
                edit: false
            }
        },

        created(){
            this.fetchToDo();
        },


        methods: {
            fetchToDo(page_url){
            let vm = this;
            page_url = page_url || '/api/todo_list'
                fetch(page_url)
                .then(res => res.json())
                .then(res =>{
                    this.notes = res.data;
                    console.log(this.notes);
                    vm.makePagination(res.meta, res.links);
                })
            },

            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },

            addToDo(){
                if(this.edit === false){
                    fetch('api/todo', {
                        method: 'post',
                        credentials: 'same-origin',
                        body: JSON.stringify(this.note),
                        headers: {
                            'content-type': 'application/json',
                            'Accept': 'application/json',
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                    this.note.text = '';
                    this.note.date = '';
                        this.fetchToDo();
                    })
                    .catch(err => console.log('alert:'+err));
                } else {
                    fetch('api/todo', {
                        method: 'put',
                        credentials: 'same-origin',
                        body: JSON.stringify(this.note),
                        headers: {
                            'content-type': 'application/json',
                            'Accept': 'application/json',
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                    this.note.text = '';
                    this.note.date = '';
                    this.note.id = '';
                    this.edit = false;
                        this.fetchToDo();
                    })
                    .catch(err => console.log('alert:'+err));
                }
            },

            deleteToDo(id){
                if(confirm('Delete this?')){
                    fetch(`api/todo/${id}`, {
                        method: 'delete'
                    })
                    .then(res=>res.json())
                    .then(data =>{
                        this.fetchToDo();
                    })
                }
            },

            editToDo(note){
                this.edit = true;
                this.note.id = note.id;
                this.note.to_do_id = note.id;
                this.note.text = note.text;
                this.note.date = note.date;
            },

            markAs(e, id){
                let bool = e.target.checked;
                this.note.id = id;
                if(bool) this.note.complete = 1;
                else this.note.complete = 0;
                alert(this.note.complete);
                fetch('api/todo_mark', {
                        method: 'put',
                        credentials: 'same-origin',
                        body: JSON.stringify(this.note),
                        headers: {
                            'content-type': 'application/json',
                            'Accept': 'application/json',
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                    })
                    .catch(err => console.log('alert:'+err));
            }

        }
    }
</script>


<style>
    body {
        background: white;
    }

    .note {
        color: grey;
        font-size: 12px;
        font-style: italic;
        font-weight: bold
    }

    .finished {
        background: #E0FFFF;
    }

    .unfinished {
        background: #FFE4E1;
    }

    .today {
        background: #f6ff9f;
    }
</style>