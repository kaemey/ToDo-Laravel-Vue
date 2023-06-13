<template>

      <div class="container py-5 h-100">
         <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col col-lg-9 col-xl-7">
               <div class="card rounded-3">
                  <div class="card-body p-4">
                     <h4 class="text-center my-3 pb-3">Send Todo lists</h4>
                     <table class="table mb-4">
                        <thead>
                           <tr>
                              <th scope="col">
                                 <p class="fs-3">User</p>
                              </th>
                              <th scope="col">
                                 <p class="fs-3">Commands</p>
                              </th>
                           </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <input type="text" v-model="user"> 
                                </td>
                                <td>
                                    <button @click.prevent="SendTodos()" type="button" class="btn btn-success btn-lg">Send</button><br><br>
                                    <a href="/" class="btn btn-primary btn-lg mt-2">Home</a>
                                </td>
                            </tr>
                        </tbody>
                     </table>
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
                user: null,
            }
        },

        methods: {

            SendTodos(){
                let formData = new FormData();
                axios.post('/api/todo/send/',{user: this.user}
                ).then(
                    this.cancelEdit(),                  
                );

                setTimeout(()=>{
                this.$parent.getTodos()
                },300);

            },

        }
    }

</script>
