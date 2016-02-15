<template lang='jade'>

.map_tile(:style="tile.box"
	:class="{active: active}")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
module.exports =

	props: [
		'tile'
		'active'
	]


	ready: ->
		console.log @tile


</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.map_tile
	background #999
	border 1px solid black
	position absolute

	&.active
		border-width 2px
		z-index 2
</style>
