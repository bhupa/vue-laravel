<template>
<div>

			<div class="container">

				<!--~~~~~~~ TABLE ONE ~~~~~~~~~-->
				<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">

                    <div class="space">
                        <Input v-model="logindata.email"  type="email" placeholder="Email"  width="300px"/>
                    </div>
                    <div class="space">
                        <Input  v-model="logindata.password" type="password" placeholder="Password" width="300px"/>
                    </div>
                     <div class="login_footer">
                            <Button type="primary"  @click="login" :disabled="isLogging" :loading="isLogging">{{ isLogging ? 'Login....' :'Login'}}</Button>
                    </div>
                </div>
            </div>


</div>

</template>
<script>
export default {
        data(){
            return {
                logindata:{
                    email:'',
                    password:''
                },
                 isLogging: false
            }

        },
        methods: {
            async login(){
                console.log(this.logindata);
                if(this.logindata.email.trim() == '') return this.e('Email is required')
                if(this.logindata.password.trim() == '') return this.e('Password is required')
                     const res = await  this.callApi('post','app/user-login',this.logindata)

             if(res.status === 200){
                 this.s(res.data.msg)
                 window.location = '/'
             }else {
                 if(res.status === 401 ){
                   this.i(res.data.msg)
                 }else if(res.status === 422){
                        for( let i in res.data.errors){
                        this.e(res.data.errors[i][0])
                     }
                 }else {
                     this.swr();
                 }
             }
            }
        }

}
</script>

<style  scoped>
._1adminOverveiw_table_recent {
    margin :0 auto;
    margin-top:220px;
}
.login_footer {
    text-align:right;
}
</style>
