<template>
     <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Tag Lists  <Button v-if="isWritePemitted" @click="addModal=true"><Icon type="ios-add" /></Button></p>


					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
								<th>Tag Name</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(tag, i) in tags" :key="i" >
								<td>{{tag.id}}</td>
								<td class="_table_name">{{tag.tagName}}</td>
								<td>{{tag.created_at}}</td>
								<td>
									<button class="_btn _action_btn edit_btn1" type="button" v-if="isUpdatePemitted" @click="showeditModal(tag,i)">Edit</button>

									<button class="_btn _action_btn make_btn1" type="button" v-if="isDeletePemitted" @click="showdeleteModal(tag,i)"  long :loading="deleteModal" :disabled="deleteModal">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->

								<!-- ITEMS -->



						</table>
					</div>
				</div>

                 <Modal
                v-model="addModal"
                title="Add Tag"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="data.tagName" placeholder="Enter something..." style="width: 300px" />
                <div slot="footer">
                    <Button type="default" @click="addModal=false">Close</Button>
                    <Button type="primary" @click="addTag" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Adding ... ' : 'Add tag'}}</Button>

                </div>
            </Modal>
               <Modal
                v-model="editModal"
                title="Edit Tag"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="editData.tagName" placeholder="Enter something..." style="width: 300px" />
                <div slot="footer">
                    <Button type="default" @click="editModal=false">Close</Button>
                    <Button type="primary" @click="editTag" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Edit ... ' : 'Edit tag'}}</Button>

                </div>
            </Modal>

  <deleteModal></deleteModal>

			</div>
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
            data : {
                tagName:''
            },
            addModal:false,
            editModal:false,
            isAdding:false,
            isDeleting:false,
            deleteModal:false,
            tags:[],
            editData:{
                tagName:''
            },
            index:-1,
            deleteItem:{},
            i:-1,



        }
    },
    methods:{
       async addTag(){
            if(this.data.tagName.trim() == '') return this.e('Tag name is required')
             const res = await  this.callApi('post','app/create-tag',this.data)

             if(res.status === 201){
                 this.tags.unshift(res.data)
                    this.s('Tag has been added successfully!')
                    this.data.tagName = ''
                    this.addModal = false
             }else {
                 if(res.status === 422){
                        if(res.data.errors.tagName){
                            this.i(res.data.errors.tagName[0])
                        }
                 }else {
                     this.swr();
                 }
             }

        },
         async editTag(){
             console.log(this.editData.tagName)
             if(this.editData.tagName.trim() == '') return this.e('Tag name is required')
             const res = await  this.callApi('post','app/edit-tag',this.editData)

             if(res.status === 200){
                 this.tags[this.index].tagName  = this.editData.tagName
                    this.s('Tag has been edit successfully!')

                    this.editModal = false
             }else {
                 if(res.status === 422){
                        if(res.data.errors.tagName){
                            this.i(res.data.errors.tagName[0])
                        }
                 }else {
                     this.swr();
                 }
             }

        },
      showeditModal(tag,index){
          let obj = {
              id : tag.id,
              tagName : tag.tagName

          }
          this.editData = obj
          this.editModal = true
          this.index = index
      },

    showdeleteModal(tag,i){

       const deleteModalObj = {
            showDeleteModal: true,
            deleteUrl : 'app/delete-tag',
            data : tag,
            deletingIndex: i,
            isDeleted : false,

        }



        this.$store.commit('setDeletingModalObj', deleteModalObj)
        // this.deleteItem = tag
        // this.i = i
        // this.deleteModal = true

    },
   },


    async created(){
        const res = await this.callApi('get','/app/get-tag')
        if(res.status == 200){
            this.tags = res.data
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
                console.log(obj)
               if(obj.isDeleted){
                    this.tags.splice(obj.deletingIndex,1)
               }
            }
    }

}
</script>
