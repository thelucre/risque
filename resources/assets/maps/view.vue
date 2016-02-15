<template lang='jade'>

.map_view
	template(v-for="tile in map.tiles")
		tile(:tile="tile" @click.prevent="selectTile(tile)"
			:active="currentTile == tile")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
module.exports =

	props: [
		'map'
	]

	data: ->
		currentTile: null

	components:
		'tile': require './tile'

	ready: ->
		console.log 'map loaded'

	methods:
		selectTile: (tile) ->
			@currentTile = tile
			@$dispatch 'tileSelected', @currentTile

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.map_view
	background #ccc
	width 800px
	height 480px
	position relative

</style>
