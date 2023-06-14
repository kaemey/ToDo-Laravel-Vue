<template>
<ZoomComponent ref="zoom"></ZoomComponent>
<div :class="isEdit() ? '': 'd-none'">
      <div class="container py-5 h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
               <div class="card rounded-3">
                  <div class="card-body p-4">

                     <div class="container">
                        <div class="row">                             
                           <div class="col-sm">
                              <h4 class="text-left my-3 pb-3 fs-2">Todo list</h4>
                           </div>
                           <div class="col-sm">
                              <input type="text" v-model="searchval" v-on:input="Search()" class="form-control rounded mt-3" placeholder="Поиск">
                           </div>
                           <div class="col-sm mt-3">
                              <select v-model="choosedTags" multiple v-on:change="TagSearch()">
                                 <option v-for="searchtag in tagsSearchData" :value="searchtag.value">{{ searchtag.label }}</option>
                              </select>
                              <!-- <Multiselect
                                 v-on:input="TagSearch()"
                                 v-model="choosedTags"
                                 :options="tagsSearchData"
                                 placeholder="Теги"
                                 :disabled="searchval ? true : false"
                                 mode="multiple"
                              /> -->
                           </div>
                           <div class="col-sm" style="text-align: right;">         
                              <a href="/" class="btn btn-primary btn-lg mt-2">Home</a>
                           </div>
                        </div>
                     </div>
                     
                     <form id="TodoForm">
                        <div class="text-center">
                           <div class="row">
                              <div class="col-8">
                                 <input type="text" v-model="title" id="title" class="form-control" placeholder="Что нужно сделать?" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                              </div>
                              <div class="col-4">
                                 <button type="button" @click.prevent="postData" id="submit_btn" class="btn btn-primary">Запланировать</button>
                              </div>
                           </div>
                           <div class="mt-3 mb-3">
                              <input ref="file" id="file" v-on:change="fileUpload()" class="form-control form-control-lg" type="file">
                           </div>
                           <div class="mt-3 mb-3">
                              <input type="text" ref="taginput" v-on:input="tagPusher()" class="form-control" placeholder="Теги" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg">
                           </div>
                           <div v-if="tags.length > 0" class="mt-3 mb-3" style="display: inline;">
                                 <span v-for="tag in tags" style="background-color: #f0ad4e; padding: 0.25em 0.4em; color: #fff; margin: 5px; border-radius: 0.25rem;">{{tag}}</span>
                           </div>
                        </div>
                     </form>
                     
                     <table class="table mb-4">
                        <thead>
                           <tr>
                              <th scope="col">
                                 <p class="fs-3" style="max-width:250px; width: 200px;">Text</p>
                              </th>
                              <th scope="col">
                                 <p class="fs-3" style="max-width:250px; width: 200px;">Image</p>
                              </th>
                              <th scope="col">
                                 <p class="fs-3">Commands</p>
                              </th>
                           </tr>
                        </thead>
                        <tbody>

                              <template v-if="searchval || searchData.length > 0" v-for="todo in searchData">
                                 <tr>
                                    <td>
                                       <p class="fs-4"> {{ todo.title }} </p>
                                    </td>
                                    <td>
                                       <img v-if="todo.imgpath" @click.prevent="zoomImage(todo.imgpath)" :src="todo.imgpath" width="150" height="150">
                                    </td>
                                    <td>
                                       <br><button @click.prevent="openEditForm(todo.id, todo.title, todo.imgpath)" type="button" class="btn btn-success">Edit</button><br><br>
                                       <button @click.prevent="deleteTodo(todo.id)" type="button" class="btn btn-danger">Delete</button>
                                    </td>
                                 </tr>
                              </template>

                              <template v-else v-for="todo in todos">
                                 <tr>
                                    <td>
                                       <p class="fs-4" style="max-width:250px; width: 200px;"> {{ todo.title }} </p>
                                    </td>
                                    <td align="left">
                                       <a :href="todo.imgpath" target="_blank"><img v-if="todo.imgpath" :src="todo.imgpath" width="150" height="150"></a>
                                    </td>
                                    <td>
                                       <br><button @click.prevent="openEditForm(todo.id, todo.title, todo.imgpath)" type="button" class="btn btn-success">Edit</button><br><br>
                                       <button @click.prevent="deleteTodo(todo.id)" type="button" class="btn btn-danger">Delete</button>
                                    </td>
                                 </tr>
                              </template>

                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
   </div>
</div>

<EditComponent ref="edit"></EditComponent>

</template>

<script>
import Multiselect from '@vueform/multiselect'
import EditComponent from './EditComponent.vue';
import ZoomComponent from './ZoomComponent.vue';

    export default {
    data() {
        return { 
            choosedTags: new Array(),
            searchval: null,
            searchData: new Array(),
            title: null,
            tags: new Array(),
            editingTodo: null,
            editingId: null,
            image: null,
            todos: null,
            tagsData: null,
            tagsSearchData: new Array(),
            zoomimg: null
        };
    },
    mounted() {
        this.getTodos();
    },
    methods: {
        getTodos() {
            this.tagsSearchData = new Array();

            axios.get("/api/todo/get")
                .then(response => (
                     this.todos = response.data.todos,
                     this.tagsData = response.data.tags,
                     this.tagsData.forEach( (tagobj) =>{
                        this.tagsSearchData.push(
                           {
                              value: tagobj.id,
                              label: tagobj.title
                           });
                     })
            ));
            
        },
        fileUpload() {
            this.image = this.$refs.file.files[0];
        },
        postData() {
            if (this.title){
               let formData = new FormData();
               formData.append("title", this.title);
               formData.append("file", this.image);
               if(this.tags.length > 0){formData.append("tags", this.tags);}           
               axios.post("/todo/store", formData, {
                  headers: {
                     "Content-Type": "multipart/form-data"
                  }
               }).then(res => (this.getTodos()));
               this.title = null;
               this.tags = new Array();
               this.$refs.file.value = null;
            }
        },
        deleteTodo(id) {
            axios.delete(`/api/todo/` + id)
                .then(response => (
            this.getTodos()));
        },
        openEditForm(id, title, imgpath) {
            this.$refs.edit.id = id;
            this.$refs.edit.title = title;
            this.$refs.edit.isDelImg = false;
            this.$refs.edit.imgpath = imgpath;
            this.editingId = id;
        },
        isEdit() {
            return this.editingId == null;
        },
        zoomImage(path){
            this.zoomimg = path;
        },
        tagPusher(){
         let text = `${this.$refs.taginput.value}`;
            if(text != ","){
               if(text.includes(',')){
                  text = text.slice(0, text.length-1);
                  this.tags.push(text);
                  this.$refs.taginput.value = '';
               }
            }
            else{
               this.$refs.taginput.value = '';
            }
        },
        Search(){

            if(this.choosedTags.length == 0){

               this.searchData = new Array();
               this.todos.forEach(( todo ) => {
                  if (todo.title.includes(this.searchval)){
                     this.searchData.push(todo);
                  }
               });
               
            }

        },
        TagSearch(){

            if(this.searchval == null){

               this.searchData = new Array();

               this.tagsData.forEach( (tagData) => {
                  
                  for (let i = 0; i < this.choosedTags.length; i++) {
                     
                     if (tagData.id == this.choosedTags[i]){
                        
                        this.todos.forEach( (todo) => {
                           
                           if(tagData.todo_id == todo.id){

                              this.searchData.push(todo);

                           }

                        });

                     }

                  }
                  
               });
            }

        }
    },
    components: { EditComponent, ZoomComponent, Multiselect }
}
</script>
<style src="@vueform/multiselect/themes/default.css"></style>
