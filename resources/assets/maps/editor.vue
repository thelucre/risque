<template lang='jade'>


.map_editor
	.controls
		button(@click="makeNewTile") New Tile
		button(@click="makeNewRegion") New Region

	.editor-wrap
		map-view(v-el:map
			:map="map"
			:layout="tab"
			:region="currentRegion")

		.edit_pane
			.tabs
				.tab(@click="changeTab('tiles')"
					:class="{ active: tab == 'tiles'}") Tiles
				.tab(@click="changeTab('regions')"
					:class="{ active: tab == 'regions'}") Regions

			edit-tile(v-if="currentTile && tab == 'tiles'"
				:tile="currentTile"
				:map="map")

			edit-region(v-if="tab == 'regions'"
				v-ref:regionedit
				:region="currentRegion"
				:map="map")

	.actions
		form( method="post"  action="/admin/maps/save")
			input(type="submit" value="Save" @click.prevent.stop="save")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
stubs = require './stubs'
keyManager = require 'utils/key-manager'

module.exports =

	props: [
		'map'
	]

	data: ->
		currentTile: null
		currentRegion: null
		tab: 'tiles'

	components:
		'map-view':   require './view'
		'tile':       require './tile'
		'edit-tile':  require './edit-tile'
		'edit-region':  require './edit-region'

	ready: ->
		console.log 'map data: ', @map

	events:
		tileSelected: (tile) ->
			@currentTile = tile

		regionSelected: (region) ->
			@currentRegion = region

		connectionsChanged: (connections) ->
			@connections = connections
			@$broadcast 'connectionsChanged', @connections

		toggleRegionTile: (tile) ->
			@$refs.regionedit.$emit 'toggleRegionTile', tile

	methods:
		save: ->
			this.$http.post '/admin/maps/save', { map: @map }
				.then (data) ->
					console.log JSON.parse data.request.data

		makeNewTile: ->
			@map.tiles.push stubs.tile()

		makeNewRegion: ->
			stub = stubs.region()
			@map.regions.push stub
			@currentRegion = stub

		changeTab: (tab) ->
			@tab = tab


</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.map_editor

	.editor-wrap
		position relative

	.edit_pane
		border-left 1px solid black
		min-height 480px
		background white
		position absolute
		top 0
		right 0
		width calc(100% - 800px)

	.tabs
		position absolute
		transform translateY(-100%)
		width 100%

		.tab
			display inline-block
			padding 5px
			background #ccc
			border 1px solid

			&.active
				background white
</style>
