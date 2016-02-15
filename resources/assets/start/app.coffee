console.log 'HERE BISH'

Vue.use require 'vue-resource'
Vue.http.headers.common['X-CSRF-TOKEN'] = $('meta[name="csrf-token"]').attr('content')

console.log Vue.http.headers.common

app = new Vue
	el: '#app'

	ready: ->
		console.log 'dwaggin'

	components:
		'map-editor': require 'maps/editor'
