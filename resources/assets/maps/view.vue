<template lang='jade'>

.map_view(class="{{ layout }}")
	template(v-for="tile in map.tiles" v-ref:tiles)
		tile(
			:tile="tile"
			track-by="id"
			@click.prevent="selectTile(tile)"
			:active="currentTile == tile"
			:$map="$el"
			:connections="connections"
			:region="region"
			:users="users")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
keyManager = require 'utils/key-manager'

module.exports =

	props: [
		'map'
		'layout'
		'region'
		'users'
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
			if @layout == 'tiles'
				if keyManager.isShiftDown() and @currentTile?
					target = @getTileComponentById @currentTile.id
					target.$emit 'toggleConnection', tile
				else
					@currentTile = tile
					@$dispatch 'tileSelected', @currentTile
			else if @layout == 'regions'
				return if not @region
				@$dispatch 'toggleRegionTile', tile

		getTileComponentById: (id) ->
			return _.first _.filter(@$refs.tiles, {'tile': { 'id': id }})

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
@require '~stylus/variables'
.map_view
	background blue
	width 800px
	height 480px
	position relative

	&.game
		margin 0 auto

</style>
