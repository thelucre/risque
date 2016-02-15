<template lang='jade'>

.map_editor
	map-view(:map="map")

	.edit_pane
		edit-tile(v-if="currentTile"
			:tile="currentTile")

	.actions
		form( method="post"  action="/admin/maps/save")
			input(type="submit" value="Save" @click.prevent.stop="save")
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
		'map-view':   require './view'
		'tile':       require './tile'
		'edit-tile':  require './edit-tile'

	ready: ->
		console.log 'map editor started'

	events:
		tileSelected: (tile) ->
		 @currentTile = tile

	methods:
		save: ->
			this.$http.post '/admin/maps/save', { map: @map }
				.then (data) ->
					console.log JSON.parse data.request.data

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.map_editor

	position relative

	.edit_pane
		border-left 1px solid black
		min-height 480px
		background white
		position absolute
		top 0
		right 0
		width calc(100% - 800px)
</style>
