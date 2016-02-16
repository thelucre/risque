<template lang='jade'>

.map_tile(:style="tile.box"
	:class="{active: active, connected: connected}"
	@drag="onDrag"
	@dragStart="onDragStart"
	draggable="true")
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

			#
			# rel =
			# 	x: (e.x - mapOffset.left )
			# 	y: (e.y - mapOffset.top )
			# console.log e.offsetX, e.offsetY

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.map_tile
	background #999
	border 1px solid black
	position absolute
	z-index 0

	&.active
		border-color red !important
		z-index 2

	&.connected
		border-color blue
		z-index 1
</style>
