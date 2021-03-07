<template>
     <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">User Lists  <Button @click="addModal=true"><Icon type="ios-add" /></Button></p>


					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
								<th>Full Name</th>
                                <th>Email</th>
                                <th>User type</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(user, i) in userList" :key="i" >
								<td>{{user.id}}</td>
								<td class="_table_name">{{user.fullname}}</td>
                                <td >{{user.email}}</td>
                                 <td >{{user.userType}}</td>
								<td>{{user.created_at}}</td>
								<td>
									<button class="_btn _action_btn edit_btn1" type="button" @click="showeditModal(user,i)">Edit</button>

									<button class="_btn _action_btn make_btn1" type="button" @click="showdeleteModal(user,i)"  long :loading="deleteModal" :disabled="deleteModal">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->

								<!-- ITEMS -->



						</table>
					</div>
				</div>

                 <Modal
                v-model="addModal"
                title="Add User Detials"
                :mask-closable="false"
                :closable="false"
                >
                <Input type="text" v-model="data.fullName" placeholder="Enter fullname" style="width: 300px" />
                <div class="space"></div>
                 <Input type="email" v-model="data.email" placeholder="Enter email" style="width: 300px" />
                 <div class="space"></div>
                 <Input type="password" v-model="data.password" placeholder="Enter password" style="width: 300px" />
                 <div class="space"></div>
                 <!-- <select v-model="data.userType" id="" style="width: 300px">
                        <Option value="Admin">Admin</Option>>
                        <Option value="User">User</Option>>
                 </select> -->
                 <Select v-model="data.role_id" style="width:300px" placeholder="Select user type">
                     <Option  v-for="(r,i) in roles"  :key="i" :value="r.id" v-if="roles.length">{{r.roleName}}</Option>
                        <!-- <Option value="User">User</Option> -->
                </Select>


                  <div class="space"></div>
                <div slot="footer">
                    <Button type="default" @click="addModal=false">Close</Button>
                    <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Adding ... ' : 'Add tag'}}</Button>

                </div>
            </Modal>
               <Modal
                v-model="editModal"
                title="Edit User Details"
                :mask-closable="false"
                :closable="false"
                >
              <Input type="text" v-model="editData.fullName" placeholder="Enter fullname" style="width: 300px" />
                <div class="space"></div>
                 <Input type="email" v-model="editData.email" placeholder="Enter email" style="width: 300px" />
                 <div class="space"></div>
                 <Input type="password" v-model="editData.password" placeholder="Enter password" style="width: 300px" />
                 <div class="space"></div>
                 <!-- <select v-model="data.userType" id="" style="width: 300px">
                        <Option value="Admin">Admin</Option>>
                        <Option value="User">User</Option>>
                 </select> -->
                 <Select v-model="editData.userType" style="width:300px" placeholder="Select user type">
                     <Option value="Admin">Admin</Option>
                        <Option value="User">User</Option>
                </Select>
                <div slot="footer">
                    <Button type="default" @click="editModal=false">Close</Button>
                    <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Edit ... ' : 'Edit tag'}}</Button>

                </div>
            </Modal>


			</div>
		</div>

          <router-view></router-view>
    </div>
</template>

<script>

export default {

    data(){
        return {
            data : {
                fullName:'',
                email:'',
                password:'',
                role_id:''
            },
            addModal:false,
            editModal:false,
            isAdding:false,
            isDeleting:false,
            deleteModal:false,
            userList:[],
            roles:[],
            editData:{
                fullName:'',
                email:'',
                password:'',
                userType:''
            },
            index:-1,
            deleteItem:{},
            i:-1,



        }
    },
    methods:{
       async addTag(){
            if(this.data.fullName.trim() == '') return this.e('Name is required')
            if(this.data.email.trim() == '') return this.e('Email is required')
            if(!this.data.role_id) return this.e('Role name is required')
            if(this.data.password.trim() == '') return this.e('Password is required')
             const res = await  this.callApi('post','app/create-user',this.data)

             if(res.status === 201){
                 this.userList.unshift(res.data)
                    this.s('User has been added successfully!')
                    this.data.tagName = ''
                    this.addModal = false
             }else {
                 if(res.status === 422){
                     for( let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                     }

                 }else {
                     this.swr();
                 }
             }

        },
         async editTag(){
            if(this.editData.fullName.trim() == '') return this.e('Name is required')
            if(this.editData.email.trim() == '') return this.e('Email is required')
            if(this.editData.userType.trim() == '') return this.e('User type is required')
             const res = await  this.callApi('post','app/edit-user',this.editData)

             if(res.status === 200){
                 console.log(this.editData)
                 this.userList[this.index].fullname  = this.editData.fullName
                 this.userList[this.index].email  = this.editData.email
                 this.userList[this.index].userType  = this.editData.userType
                    this.s('User has been edit successfully!')
                    this.editModal = false
             }else {
                 if(res.status === 422){
                     for( let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                     }

                 }else {
                     this.swr();
                 }
             }

        },
      showeditModal(user,index){
          let obj = {
              id : user.id,
              fullName : user.fullname,
              email : user.email,
              userType: user.userType,

          }
          this.editData = obj
          this.editModal = true
          this.index = index
      },

    // showdeleteModal(tag,i){

    //    const deleteModalObj = {
    //         showDeleteModal: true,
    //         deleteUrl : 'app/delete-tag',
    //         data : tag,
    //         deletingIndex: i,
    //         isDeleted : false,

    //     }



    //     this.$store.commit('setDeletingModalObj', deleteModalObj)
    //     // this.deleteItem = tag
    //     // this.i = i
    //     // this.deleteModal = true

    // },
   },


    async created(){

        const[res,roleLists]= await Promise.all([
                this.callApi('get','/app/user-lists'),
                this.callApi('get','/app/role-lists')
        ])
        // const res = await this.callApi('get','/app/user-lists')

        if(res.status == 200){

            this.userList = res.data
        }else{
            this.swr();
        }
         if(roleLists.status == 200){

            this.roles = roleLists.data
        }else{
            this.swr();
        }
    },
    // components:{
    //     deleteModal
    // },
    //   computed: {
    //     ...mapGetters(['getDeleteModalObj'])
    // },
    // watch: {
    //         getDeleteModalObj(obj){
    //             console.log(obj)
    //            if(obj.isDeleted){
    //                 this.tags.splice(obj.deletingIndex,1)
    //            }
    //         }
    // }

}
</script>
