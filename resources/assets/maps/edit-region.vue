<template lang='jade'>

.edit_region
	p REGIONS
	select(v-model="selected")
		option(value="") Select Region
		option(v-for="region in map.regions"
			:value="region.id") {{ region.name }}

	template(v-if="region")
		hr
		p
			label Name
			input(type="text" v-model="region.name")
		p
			label ID:
			span {{ region.id }}

		p
			label Bonus
			input(type="number" v-model="region.bonus" min="0" max="99")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
module.exports =

	props: [
		'map'
	]

	data: ->
		selected: null
		region: null

	watch:
		selected: (nv,ov) ->
			if not @selected
				@region = null
			else
				@region = _.first _.filter(@map.regions, { id: @selected })

			@$dispatch 'regionSelected', @region

	events:
		toggleRegionTile: (tile) ->
			index = @region.tiles.indexOf tile.id
			if index < 0
				@region.tiles.push(tile.id)
			else
				@region.tiles.splice index, 1

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
.edit_region
	padding 20px

</style>
