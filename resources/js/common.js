import {mapGetters} from 'vuex'
export default
{
    data(){
        return {
            data: {
                tagName: ''
            }
        }
    },
    methods:{
       async callApi(method,url,data){
                try{
                    return await axios({
                        method: method,
                        url: url,
                        data: data
                      });

                }catch(e){
                       return  e.response;
                }


        },
        i (desc,title="hey") {
            this.$Notice.info({
                title: desc,
                desc: title
            });
        },
        s(desc,title="Great") {
            this.$Notice.success({
                title: desc,
                desc: title
            });
        },
        w (desc,title="Oops !") {
            this.$Notice.warning({
                title: desc,
                desc: title
            });
        },
        e (desc,title="Oops !") {
            this.$Notice.error({
                title: desc,
                desc: title
            });
        },
        swr (desc="some thing went wrong! Please try again",title="hey") {
            this.$Notice.error({
                title: desc,
                desc: title
            });
        },

        checkUserPermission(key){
            if(!this.userPermission) return true
            let isPermitted = false;
            for (let d of this.userPermission){
                console.log(d[key])
                if(this.$route.name == d.name){
                    if(d[key]){
                        isPermitted = true
                        break;
                    }else{
                        break;
                    }

                }
            }
            return isPermitted;
        }
    },
    computed:{
        ...mapGetters({
            'userPermission' : 'getUserPermission'
        }),
        isReadPemitted(){
          return  this.checkUserPermission('read')
        },
        isWritePemitted(){
            return  this.checkUserPermission('write')
        },
        isUpdatePemitted(){
            return  this.checkUserPermission('update')
        },
        isDeletePemitted(){
            return  this.checkUserPermission('delete')
        }
    }
}
