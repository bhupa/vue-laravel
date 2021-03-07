<template >
<div>
    <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Role Lists  <Button @click="addModal=true"><Icon type="ios-add" /></Button></p>


					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
								<th> Name</th>
                                <!-- <th>Icon Image</th> -->
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->
                            <tr v-for="(role, i) in roles" :key="i">
                                <td>{{i+1}}</td>
								<td class="_table_name">{{role.roleName}}</td>

								<td>{{role.created_at}}</td>
								<td>
									<button class="_btn _action_btn edit_btn1" type="button" @click="showeditModal(role,i)">Edit</button>

									<button class="_btn _action_btn make_btn1" type="button" @click="showdeleteModal(role,i)"  long :loading="deleteModal" :disabled="deleteModal">Delete</button>
								</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <Modal
                v-model="addModal"
                title="Add Role"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="dataRole.roleName" placeholder="Enter something..." style="width: 300px" />
                <div slot="footer">
                    <Button type="default" @click="addModal=false">Close</Button>
                    <Button type="primary" @click="addRole" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Adding ... ' : 'Add Role'}}</Button>

                </div>
            </Modal>
             <Modal
                v-model="editModal"
                title="Edit Role"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="editData.roleName" placeholder="Enter something..." style="width: 300px" />
                <div slot="footer">
                    <Button type="default" @click="editModal=false">Close</Button>
                    <Button type="primary" @click="editRole" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Editing ... ' : 'Edit Role'}}</Button>

                </div>
            </Modal>
 <deleteModal></deleteModal>
    </div>

 <router-view></router-view>
</div>

</template>

<script>
import deleteModal from '../component/deleteModule.vue'
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
            dataRole:{
            roleName:'',
            },
             addModal:false,
            editModal:false,
            isAdding:false,
            isDeleting:false,
            deleteModal:false,
            roles:[],
            editData:{
                roleName:''
            },
             isEditingItem:false
    }

    },
    methods: {
       async addRole(){

            if(this.dataRole.roleName.trim() == '') return this.e('Role name is required')
             const res = await  this.callApi('post','app/create-role',this.dataRole)

             if(res.status === 201){
                 this.roles.unshift(res.data)
                    this.s('Role has been added successfully!')
                    this.dataRole.roleName = ''
                    this.addModal = false
             }else {
                 if(res.status === 422){
                        if(res.data.errors.roleName){
                            this.i(res.data.errors.roleName[0])
                        }
                 }else {
                     this.swr();
                 }
             }
        },
         showeditModal(role,index){
          let obj = {
              id : role.id,
              roleName: role.roleName,

          }
          this.editData = obj
          this.editModal = true
          this.index = index,
          this.isEditingItem = true
      },
      async editRole(){

            if(this.editData.roleName.trim() == '') return this.e('Role name is required')
             const res = await  this.callApi('post','app/edit-role',this.editData)

             if(res.status === 200){
                    this.s('Role has been added successfully!')
                      this.roles[this.index].roleName  = this.editData.roleName
                    this.editData.roleName = ''
                    this.editModal = false


             }else {
                 if(res.status === 422){
                        if(res.data.errors.roleName){
                            this.i(res.data.errors.roleName[0])
                        }
                 }else {
                     this.swr();
                 }
             }
        },

         showdeleteModal(category,i){
         const deleteModalObj = {
            showDeleteModal: true,
            deleteUrl : 'app/delete-role',
            data : category,
            deletingIndex: i,
            isDeleted : false,
        }
        this.$store.commit('setDeletingModalObj', deleteModalObj)

    },

    },
    async created(){
        this.token = window.laravel.csrfToken;

        const res = await this.callApi('get','/app/role-lists')

        if(res.status == 200){
            this.roles = res.data
        }else{
            this.swr();
        }
    },
     components:{
        deleteModal
    },
      computed: {
        ...mapGetters(['getDeleteModalObj'])
    },
    watch: {
            getDeleteModalObj(obj){
               if(obj.isDeleted){
                    this.roles.splice(obj.deletingIndex,1)
               }
            }
    }
}
</script>
