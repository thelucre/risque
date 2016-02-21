<template lang='jade'>

.map_tile(:style="tile.box"
	:class="{active: active, connected: connected, region: inRegion}"
	@drag="onDrag"
	@dragStart="onDragStart"
	draggable="true")
		.label {{tile.units}}
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
module.exports =

	data: ->
		connected: false

	props: [
		'tile'
		'active'
		'connections'
		'region'
		'$map' # reference to the map's DOM element
	]

	ready: ->
		@$map = $(@$map)
		@$el = $(@$el)

		setTimeout =>
			@mapDim =
				w: @$map.outerWidth()
				h: @$map.outerHeight()
		, 300

	watch:
		connections: ->
			@connected = _.filter(@connections, {'id': @tile.id}).length

	methods:
		onDragStart: (e) ->
			@offset =
				x: (e.pageX - @$el.offset().left)
				y: (e.pageY - @$el.offset().top)
			dragIcon = document.createElement 'img'
			dragIcon.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7"
			dragIcon.width = 100
			e.dataTransfer.setDragImage dragIcon, -10, -10

		onDrag: (e) ->
			pos =
				x: ((@$el.position().left + e.offsetX - @offset.x)/@mapDim.w*100).toFixed(2)
				y: ((@$el.position().top + e.offsetY - @offset.y)/@mapDim.h*100).toFixed(2)

			return if (pos.x < 0 or pos.y < 0)

			@tile.box.left = pos.x+'%'
			@tile.box.top = pos.y+'%'

	events:
		toggleConnection: (tile) ->
			# Tile can't be connected to itself
			return if tile.id == @tile.id
			index = @tile.connections.indexOf tile.id

			if index == -1
				@tile.connections.push tile.id
			else
				@tile.connections.splice index, 1

	computed:
		inRegion: ->
			return false if not @region
			return @region.tiles.indexOf(@tile.id) >= 0

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.map_tile
	background #999
	border 1px solid black
	position absolute
	z-index 0
	transition background 150ms 0ms ease-in-out

	.label
		position absolute
		top 50%
		right 50%
		transform translate(50%, -50%)
		font-weight 700

	.tiles &
		&.active
			background red
			z-index 2

		&.connected
			background blue
			z-index 1

	.regions &
		&.region
			background green

	// .game &
	//

</style>
