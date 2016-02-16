<template lang='jade'>

.map_view
	template(v-for="tile in map.tiles" v-ref:tiles)
		tile(
			:tile="tile"
			track-by="id"
			@click.prevent="selectTile(tile)"
			:active="currentTile == tile"
			:$map="$el"
			:connections="connections")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
keyManager = require 'utils/key-manager'

module.exports =

	props: [
		'map'
	]

	data: ->
		currentTile: null
		connections: []

	ready: ->
		console.log @

	components:
		'tile': require './tile'

	events:
		connectionsChanged: (connections) ->
			@connections = connections

	methods:
		selectTile: (tile) ->
			if keyManager.isShiftDown() and @currentTile?
				target = @getTileComponentById @currentTile.id
				target.$emit 'toggleConnection', tile
			else
				@currentTile = tile
				@$dispatch 'tileSelected', @currentTile

		getTileComponentById: (id) ->
			return _.first _.filter(@$refs.tiles, {'tile': { 'id': id }})

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.map_view
	background #ccc
	width 800px
	height 480px
	position relative

</style>
