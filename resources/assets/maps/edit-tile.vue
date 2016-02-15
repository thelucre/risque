<template lang='jade'>

.edit_tile
	p
		strong EDIT TILE
	p
		label Name
		input(type="text" v-model="tile.name")
	hr
	p
		label Top
		input(type="text" v-model="tile.box.top")
	p
		label Left
		input(type="text" v-model="tile.box.left")
	p
		label Width
		input(type="text" v-model="tile.box.width")
	p
		label Height
		input(type="text" v-model="tile.box.height")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
module.exports =

	props: [
		'tile'
	]

	ready: ->
		console.log 'tile edit loaded'

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.edit_tile
	padding 20px

</style>
