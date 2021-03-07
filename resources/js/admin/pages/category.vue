<template>
     <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Category Lists  <Button @click="addModal=true"><Icon type="ios-add" /></Button></p>


					<div class="_overflow _table_div">
						<table class="_table">
								<!-- TABLE TITLE -->
							<tr>
								<th>Id</th>
								<th> Name</th>
                                <th>Icon Image</th>
								<th>Created at</th>
								<th>Action</th>
							</tr>
								<!-- TABLE TITLE -->


								<!-- ITEMS -->
							<tr v-for="(category, i) in categoryList" :key="i" >
								<td>{{category.id}}</td>
								<td class="_table_name">{{category.categoryName}}</td>
                                <td>
                                    <img :src="`uploads/${category.iconImage}`" alt="" style="width:40px">
                                </td>
								<td>{{category.created_at}}</td>
								<td>
									<button class="_btn _action_btn edit_btn1" type="button" @click="showeditModal(category,i)">Edit</button>

									<button class="_btn _action_btn make_btn1" type="button" @click="showdeleteModal(category,i)"  long :loading="deleteModal" :disabled="deleteModal">Delete</button>
								</td>
							</tr>
								<!-- ITEMS -->

								<!-- ITEMS -->



						</table>
					</div>
				</div>

                 <Modal
                v-model="addModal"
                title="Add Category"
                :mask-closable="false"
                :closable="false"
                >
                <Input v-model="data.categoryName" placeholder="Enter something..." style="width: 300px" />
                <div class="space"></div>
                <Upload
                ref="uploads"
                :headers="{'x-csrf-token': token,'X-Requested-With': 'XMLHttpRequest'}"
                :on-success="handleSuccess"
                :format="['jpg','jpeg','png']"
                :on-error="handleError"
                :on-exceeded-size="handleMaxSize"
                 action="app/upload">
        <Button icon="ios-cloud-upload-outline">Upload files</Button>
    </Upload>
    <div class="space"></div>
    <div class="demo-upload-list" v-if="data.iconImage">
        <img :src="`uploads/${data.iconImage}`" alt="">
         <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage()"></Icon>
            </div>

    </div>

                <div slot="footer">
                    <Button type="default" @click="addModal=false">Close</Button>
                    <Button type="primary" @click="addCategory" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Adding ... ' : 'Add category'}}</Button>

                </div>
            </Modal>
               <Modal

                v-model="editModal"
                title="Edit Category"
                :mask-closable="false"
                :closable="false"
                >
               <Input v-model="editData.categoryName" placeholder="Enter something..." style="width: 300px" />
                <div class="space"></div>
                <Upload v-show="isIconImageNew"
                ref="editDataUploads"
                :headers="{'x-csrf-token': token,'X-Requested-With': 'XMLHttpRequest'}"
                :on-success="handleSuccess"
                :format="['jpg','jpeg','png']"
                :on-error="handleError"

                 action="app/upload">
        <Button icon="ios-cloud-upload-outline">Upload files</Button>
    </Upload>
    <div class="space"></div>
    <div class="demo-upload-list" v-if="editData.iconImage">
        <img :src="`uploads/${editData.iconImage}`" alt="">
         <div class="demo-upload-list-cover">
              <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
            </div>

    </div>

                <div slot="footer">
                    <Button type="default" @click="closeEditModal">Close</Button>
                    <Button type="primary" @click="editCategory" :disabled="isAdding" :loading="isAdding"> {{ isAdding ? 'Edit ... ' : 'Edit category'}}</Button>

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
                iconImage:'',
                categoryName:''
            },
            addModal:false,
            editModal:false,
            isAdding:false,
            isDeleting:false,
            deleteModal:false,
            categoryList:[],
            editData:{
               iconImage:'',
                categoryName:''
            },
            index:-1,
            deleteItem:{},
            i:-1,
            token:'',
            isIconImageNew: false,
            isEditingItem:false



        }
    },
    methods:{
       async addCategory(){
            if(this.data.categoryName.trim() == '') return this.e('Category name is required')
             if(this.data.iconImage.trim() == '') return this.e('Icon image is required')
            //  this.data.iconImage = `/uploads/${data.iconImage}`
             const res = await  this.callApi('post','app/create-category',this.data)

             if(res.status === 201){
                 this.categoryList.unshift(res.data)
                    this.s('Category has been added successfully!')
                    this.addModal = false
                    this.data.categoryName = ''
                    this.data.iconImage = ''
             }else {
                 if(res.status === 422){
                        if(res.data.errors.categoryName){
                            this.i(res.data.errors.categoryName[0])
                        }
                        if(res.data.errors.iconImage){
                            this.i(res.data.errors.iconImage[0])
                        }
                 }else {
                     this.swr();
                 }
             }

        },
         async editCategory(){

            if(this.editData.categoryName.trim() == '') return this.e('Category name is required')
             if(this.editData.iconImage.trim() == '') return this.e('Icon image is required')
             const res = await  this.callApi('post','app/edit-category',this.editData)

             if(res.status === 200){
                 this.categoryList[this.index].categoryName  = this.editData.categoryName
                 this.categoryList[this.index].iconImage  = this.editData.iconImage
                    this.s('Category has been edit successfully!')

                    this.editModal = false
             }else {
                 if(res.status === 422){
                        if(res.data.errors.categoryName){
                            this.i(res.data.errors.categoryName[0])
                        }
                        if(res.data.errors.iconImage){
                            this.i(res.data.errors.iconImage[0])
                        }
                 }else {
                     this.swr();
                 }
             }

        },
      showeditModal(category,index){
          let obj = {
              id : category.id,
              categoryName: category.categoryName,
               iconImage: category.iconImage

          }
          this.editData = obj
          this.editModal = true
          this.index = index,
          this.isEditingItem = true
      },
      async deleteTag(){
        // if(!confirm('Are you sure you want to delete this tag?')) return

        this.isDeleting = true
        // this.$set(tag,'isDeleting', true)
        const res = await  this.callApi('post','app/delete-category',this.deleteItem)
        if(res.status === 200){

            this.categoryList.splice(this.i,1)
            this.s('Tag has been deleted successfully !')

        }else{
             this.swr();
        }
         this.isDeleting = true,
          this.deleteModal = false
    },
    async deleteImage(isAdd = true){

        if(!isAdd){
            this.isIconImageNew = true
            let image = this.editData.iconImage
            this.editData.iconImage = ''
            this.$refs.editDataUploads.clearFiles()
        }else {
         let image = this.data.iconImage
         this.data.iconImage = ''
         this.$refs.uploads.clearFiles()
        }


    },
    showdeleteModal(tag,i){
         const deleteModalObj = {
            showDeleteModal: true,
            deleteUrl : 'app/delete-category',
            data : tag,
            deletingIndex: i,
            isDeleted : false,

        }



        this.$store.commit('setDeletingModalObj', deleteModalObj)

    },
    handleSuccess (res, file) {
        if(this.isEditingItem){
            return this.editData.iconImage = res
        }else{
            this.data.iconImage = res
        }

     },
     handleError(res,file){
          this.$Notice.warning({
                    title: 'The file format is incorrect',
                    desc: `${file.errors.file.length ? file.errors.file[0] : 'Something went wrong'}`
                });
     },
     closeEditModal () {
         this.isEditingItem = false
          this.editModal = false
     }
            // handleFormatError (file) {
            //     this.$Notice.warning({
            //         title: 'The file format is incorrect',
            //         desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            //     });
            // },
            // handleMaxSize (file) {
            //     this.$Notice.warning({
            //         title: 'Exceeding file size limit',
            //         desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            //     });
            // },
    },

    async created(){
        this.token = window.laravel.csrfToken;

        const res = await this.callApi('get','/app/category-lists')

        if(res.status == 200){
            this.categoryList = res.data
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
                    this.categoryList.splice(obj.deletingIndex,1)
               }
            }
    }

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
</style>
