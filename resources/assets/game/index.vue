<template lang='jade'>


.game-view
	map-view(:map="gameData.map"
		layout="game"
		:users="game.users")
</template>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<script lang='coffee'>
stubs = require 'utils/stubs'
keyManager = require 'utils/key-manager'

module.exports =

	props: [
		'game'
	]

	components:
		'map-view':   require 'maps/view'

	computed:
		gameData: ->
			return JSON.parse @game.data

	ready: ->
		console.log @game

</script>

<!-- ––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––––– -->

<style lang='stylus'>
@require '~stylus/variables'
.game-view
	background transparent

</style>
