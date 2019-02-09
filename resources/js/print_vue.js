var print = new Vue({
  el: '#print',
  data: {
    activeBeers: []
  },
  mounted() {
    this.populateMenu();
  },
  methods: {
    populateMenu() {
      axios.get('/actions/get_menu.php').then(response => {
        if (response.data.error === false) {
          this.activeBeers = response.data.beers;
        } else {
          console.log('error', response.data.error)
        }
      }).catch(error => {
        console.log(error.response)
      });
    },
    sliceItems: function (start, end) {
      return this.activeBeers.slice(start, end);
    }
  }
});