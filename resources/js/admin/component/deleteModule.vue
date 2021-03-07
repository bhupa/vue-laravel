<template>
    <div>
        <Modal :value="getDeleteModalObj.showDeleteModal" width="360" :mask-closable="false"
                :closable="false">
        <p slot="header" style="color:#f60;text-align:center">
            <Icon type="ios-information-circle"></Icon>
            <span>Delete confirmation</span>
        </p>
        <div style="text-align:center">

            <p>Are you sure you want to delete tag?</p>
        </div>
        <div slot="footer">
             <Button type="default" @click="deleteModal">Close</Button>
            <Button type="error"  :disabled="isDeleting" :loading="isDeleting" @click="deleteTag()">Delete</Button>
        </div>
    </Modal>

    </div>
</template>
<script>
import {mapGetters} from 'vuex'
export default {
    data(){
        return {
            isDeleting:false
        }
    },
      methods:{
     async deleteTag(){

        this.isDeleting = true
        // this.$set(tag,'isDeleting', true)
        const res = await  this.callApi('post',this.getDeleteModalObj.deleteUrl,this.getDeleteModalObj.data)
        if(res.status === 200){
            // this.tags.splice(this.i,1)

            this.s('Tag has been deleted successfully !')
            this.$store.commit('setDeleteModal', true)


        }else{
             this.$store.commit('setDeleteModal', false)
             this.swr();

        }
        //  this.isDeleting = true,
        //   this.deleteModal = false
    },
    deleteModal(){
         this.$store.commit('setDeleteModal', false)
    }
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    }

}
</script>
