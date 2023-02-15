<template>
</template>

<script>
export default {

	created(){
		localStorage.removeItem('token')
		localStorage.removeItem('user')
        Toast.fire({
			icon: 'success',
			title: 'Logout in successfully'
		})
        axios.post('/logout').then(()=>{

    if(this.$route.query.redirect){

        window.location.href = '/login?redirect='+this.$route.query.redirect
    }else{

        window.location.href = '/login'
    }
    })


        // window.location.href='/login'
		// this.$router.push({name: '/'})
	}
}
</script>

<style lang="css" scoped>
</style>
