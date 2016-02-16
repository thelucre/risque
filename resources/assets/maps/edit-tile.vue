<template lang='jade'>

.edit_tile
	p
		strong EDIT TILE
	p
		label Name
		input(type="text" v-model="tile.name")
	p
		label ID:
		span {{ tile.id }}
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

	hr
	p
		strong CONNECTIONS
		template(v-for="connection in connectedTiles")
			.connection {{ connection.name }}
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
module.exports =

	props: [
		'tile'
		'map'
	]

	ready: ->
		@$dispatch 'connectionsChanged', @connectedTiles

	computed:
		###
		Map the connection IDs to the tile instance
		###
		connectedTiles: ->
			return _.map @tile.connections, (id) =>
				_.first _.filter(@map.tiles, {'id': id})

	watch:
		connectedTiles: ->
			@$dispatch 'connectionsChanged', @connectedTiles

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.edit_tile
	padding 20px

</style>
