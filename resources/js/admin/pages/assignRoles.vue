<template>
     <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category Lists
                       <Select v-model="data.role_id" style="width:300px" placeholder="Select user type" @on-change="changeRole">
                     <Option  v-for="(r,i) in roles"  :key="i" :value="r.id" v-if="roles.length">{{r.roleName}}</Option>
                        <!-- <Option value="User">User</Option> -->
                </Select>
                        </p>


					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>

								<th> Resource Name</th>
                                <th>Read</th>
                                <th>Write</th>
								<th>Update</th>
								<th>Delete</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							 <tr v-for="(resq, i) in  resources" :key="i" >
								<td class="_table_name">{{resq.resourceName}}</td>
                                <td>
                                     <Checkbox v-model="resq.read"></Checkbox>
                                </td>
                                <td>
                                     <Checkbox v-model="resq.write"></Checkbox>
                                </td>
                                <td>
                                     <Checkbox v-model="resq.update"></Checkbox>
                                </td>
                                <td>
                                     <Checkbox v-model="resq.delete"></Checkbox>
                                </td>

							</tr>

                              <div class="assignBut">
                                         <Button type="primary" :loading="isSending" :disabled="isSending" @click="assignRole">Assign</Button>
                              </div>



								<!-- ITEMS -->

								<!-- ITEMS -->



						</table>
					</div>
				</div>




			</div>
		</div>
          <router-view></router-view>
    </div>
</template>

<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
           data : {
                role_id:null
            },
            isSending:false,

            roles:[],

            resources: [
                {resourceName:'Tags',read:false,write:false,update:false,delete:false, name:'tags'},
                {resourceName:'Category',read:false,write:false,update:false,delete:false, name:'category'},
                {resourceName:'Users',read:false,write:false,update:false,delete:false, name:'user'},
                {resourceName:'Roles',read:false,write:false,update:false,delete:false, name:'role'},
                 {resourceName:'AssignRole',read:false,write:false,update:false,delete:false, name:'assignRole'},
                  {resourceName:'Home',read:false,write:false,update:false,delete:false, name:'/'},
                    {resourceName:'Blog',read:false,write:false,update:false,delete:false, name:'blog'},
                // {id:'5',resourceName:'Tags',read:false,write:false,update:false,delete:false, name:tags},
                // {id:'6',resourceName:'Tags',read:false,write:false,update:false,delete:false, name:tags},
                // {id:'7',resourceName:'Tags',read:false,write:false,update:false,delete:false, name:tags}
            ],
            defaultresources: [
                {resourceName:'Tags',read:false,write:false,update:false,delete:false, name:'tags'},
                {resourceName:'Category',read:false,write:false,update:false,delete:false, name:'category'},
                {resourceName:'Users',read:false,write:false,update:false,delete:false, name:'user'},
                {resourceName:'Roles',read:false,write:false,update:false,delete:false, name:'role'},
                {resourceName:'AssignRole',read:false,write:false,update:false,delete:false, name:'assignRole'},
                {resourceName:'Home',read:false,write:false,update:false,delete:false, name:'/'},
               {resourceName:'Blog',read:false,write:false,update:false,delete:false, name:'blog'},
              // {id:'5',resourceName:'Tags',read:false,write:false,update:false,delete:false, name:tags},
                // {id:'6',resourceName:'Tags',read:false,write:false,update:false,delete:false, name:tags},
                // {id:'7',resourceName:'Tags',read:false,write:false,update:false,delete:false, name:tags}
            ]



        }
    },
    methods:{
        async assignRole(){
                let datas = JSON.stringify(this.resources)
                const res = await this.callApi('post','/app/assignRoles',{'permission':datas,id:this.data.role_id})

               if(res.status == 200){
                    this.s('Role hasbeen assigned successfully')
                    let index = this.roles.findIndex(role => role.id == this.data.role_id)

                    this.roles[index].permission = datas
                }else{
                this.swr()
                }
        },
        async changeRole(){

            let index = this.roles.findIndex(role=>role.id == this.data.role_id)

            let permission = this.roles[index].permission

             if(!permission){
                 this.resources = this.defaultresources
             }else{
                this.resources = JSON.parse(permission);
             }
        }
    },

    async created(){
        this.token = window.laravel.csrfToken;

        const res = await this.callApi('get','/app/role-lists')

        if(res.status == 200){
            this.roles = res.data
            console.log(res.data[0].id)
            if(res.data.length){
                this.data.id = res.data[0].id
                if(res.data[0].permission){
                    this.resources = JSON.parse(res.data[0].permission)

                }

            }
        }else{
            this.swr();
        }
    },



}
</script>
<style>
    .demo-upload-list{
        display: inline-block;
        width: 60px;
        height: 60px;
        text-align: center;
        line-height: 60px;
        border: 1px solid transparent;
        border-radius: 4px;
        overflow: hidden;
        background: #fff;
        position: relative;
        box-shadow: 0 1px 1px rgba(0,0,0,.2);
        margin-right: 4px;
    }
    .demo-upload-list img{
        width: 100%;
        height: 100%;
    }
    .demo-upload-list-cover{
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.6);
    }
    .demo-upload-list:hover .demo-upload-list-cover{
        display: block;
    }
    .demo-upload-list-cover i{
        color: #fff;
        font-size: 20px;
        cursor: pointer;
        margin: 0 2px;
    }
    .assignBut {
        display: block;
        float: right;
        margin-top: 20px;
    }
</style>
