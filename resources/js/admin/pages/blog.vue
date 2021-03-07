<template>
     <div>
       <div class="content">
			<div class="container-fluid">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
					<p class="_title0">Blog Lists  <Button @click="addModal=true"><Icon type="ios-add" /></Button></p>


					<div class="_overflow _table_div">
                           <!-- <editor
    @load="onEditorLoad"
    @focus="onEditorFocus"
    @blur="onEditorBlur"
    @change="onEditorChange"
    @stateChange="onEditorStateChange"
    /> -->
					</div>
                </div>



			</div>
		</div>
          <router-view></router-view>
    </div>
</template>

<script>


// import Editor from '@toast-ui/vue-editor/src/Editor.vue'
// var Editor = toastui.Editor;
export default {
components: {
        // 'editor': Editor
    },
    data(){
        return {

            data : {

            },
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
        // onEditorLoad() {
        //     // implement your code
        // },
        // onEditorFocus() {
        //     // implement your code
        // },
        // onEditorBlur() {
        //     // implement your code
        // },
        // onEditorChange() {
        //     // implement your code
        // },
        // onEditorStateChange() {
        //     // implement your code
        // },

    },


}
</script>
