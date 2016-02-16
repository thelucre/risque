keys =
	shift: 16

pressed = {}

$(window).on 'keydown', (e) ->
	pressed[e.keyCode] = true

$(window).on 'keyup', (e) ->
	pressed[e.keyCode] = false

module.exports =
	isShiftDown: () ->
		return pressed[keys.shift] if pressed[keys.shift]?
		return false
