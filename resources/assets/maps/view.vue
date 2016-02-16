<template lang='jade'>

.map_view
	template(v-for="tile in map.tiles")
		tile(:tile="tile"
			@click.prevent="selectTile(tile)"
			:active="currentTile == tile"
			:$map="$el"
			:connections="connections")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
module.exports =

	props: [
		'map'
	]

	data: ->
		currentTile: null
		connections: []

	components:
		'tile': require './tile'

	events:
		connectionsChanged: (connections) ->
			@connections = connections

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
