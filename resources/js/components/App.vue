<template>
	<div id="index">
		<router-view></router-view>
	</div>
</template>

<script>

export default {
	name: "App",
	data () {

		return {};

	},
	computed: {},

	created () {

		this.$store.commit("INITIALIZE_STATE");

	},
	methods: {},
};

</script>

<style scoped>

</style>
