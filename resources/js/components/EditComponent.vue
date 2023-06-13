<template>

<div :class="this.$parent.isEdit() ? 'd-none': ''">
      <div class="container py-5 h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
               <div class="card rounded-3">
                  <div class="card-body p-4">
                     <h4 class="text-center my-3 pb-3">Editing</h4>
                     <table class="table mb-4">
                        <thead>
                           <tr>
                              <th scope="col">
                                 <p class="fs-3">Text</p>
                              </th>
                              <th scope="col">
                                 <p class="fs-3">Image</p>
                              </th>
                              <th scope="col">
                                 <p class="fs-3">Commands</p>
                              </th>
                           </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" v-model="title"> 
                                </td>
                                <td>
                                    <input ref="img" v-on:change="fileUpload()" class="form-control form-control" type="file"><br>
                                    <button v-if="isDelImg" @click.prevent="restoreImg()" type="button" class="btn btn-success">Restore image</button>
                                    <button v-else-if="imgpath" @click.prevent="deleteImage()" type="button" class="btn btn-danger">Delete image</button>
                                </td>
                                <td>
                                    <button @click.prevent="postData()" type="button" class="btn btn-success">Save</button><br><br>
                                    <button @click.prevent="cancelEdit()" type="button" class="btn btn-danger">Cancel</button>
                                </td>
                            </tr>
                            <tr>
                                 <td>
                                    <p class="fs-4" style="max-width:300px;"> {{ title }} </p>
                                 </td>
                                 <td>
                                    <img v-if="imgpath" :src="imgpath" width="150" height="150">
                                 </td>
                                 <td>
                                 </td>
                            </tr>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
   </div>
</div>

</template>

<script>

    export default {

        data() {
            return{
                image: null,
                title: null,
                id: null,
                imgpath: null,
                disbut: false,
                isDelImg: false,
                tempImgPath: null
            }
        },

        methods: {

            fileUpload(){
                this.image = this.$refs.img.files[0];
            },

            postData(){
                if (this.isDelImg) {
                    axios.delete(`/api/todo/image/` + this.id).then();
                }
                let formData = new FormData();
                formData.append('title', this.title);
                formData.append('file', this.image);
                axios.post('/todo/'+this.id,
                formData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                ).then(
                    this.cancelEdit(),                  
                );

                setTimeout(()=>{
                this.$parent.getTodos()
                },300);

            },

            cancelEdit(){
                this.$parent.editingId = null;
            },

            restoreImg(){
                this.imgpath = this.tempImgPath;
                this.isDelImg = false;
            },

            deleteImage(){
                this.isDelImg = true;
                this.tempImgPath = this.imgpath;
                this.imgpath = null;
            }
        }
    }

</script>
