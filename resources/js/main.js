Vue.component('v-select', VueSelect.VueSelect);

// Base Url of the API
const beerListJson = "/resources/data/beers.json";
const breweryListJson = "/resources/data/breweries.json";
const glasswareListJson = "/resources/data/glassware.json";

const BuildMenu = {
  template: '#build-menu',
  data: () => ({
    search: '',
    beers: [],
    activeBeers: [],
    loading: false,
    activeBeersLoading: true
  }),
  mounted() {
    this.getBeers();
    this.populateMenu();
  },
  updated() {
    // @see actions.js
    init_draft_list_sticky();
  },
  methods: {
    draggableMove: function(evt) {
      console.log('move');
      // console.log(evt.draggedContext.element.name);
      // console.log(evt.draggedContext.index);
      // console.log(evt.draggedContext.futureIndex);
    },
    draggableUpdateDrop: function(e){
      console.log('drop');
      this.updateMenu();
    },
    getBeers() {
      this.loading = true;
      axios.get(beerListJson).then(response => {
        this.beers = response.data;
        this.loading = false;
      }).catch(error => {
        console.log(error);
      });
    },
    populateMenu() {
      axios.get('/get_menu.php').then(response => {
        if (response.data.error === false) {
          this.activeBeers = response.data.beers;
          this.activeBeersLoading = false;
        } else {
          console.log('error', response.data.error)
        }
      }).catch(error => {
        console.log(error.response)
      });
    },
    addBeer(beer) {
      if (this.activeBeers.length < 18) {
        this.activeBeers.push(beer);
        this.updateMenu();
      } else {
        alert('You reached the max in your draft list.');
      }
    },
    removeBeer(index) {
      this.activeBeers.splice(index, 1);
      this.updateMenu();
    },
    updateMenu() {
      axios.post('/update_menu.php', {
        'activeBeers': this.activeBeers
      }).then(response => {
        if (response.data.error === false) {
          console.log('success update menu', response.data.message)
        } else {
          console.log('error update menu', response.data.error)
        }
      }).catch(error => {
        console.log(error.response)
      });
    }
  },
  computed: {
    filteredBeers() {
      return this.beers.filter(beer => {
        var beerTitle =  beer.brewery.label + ' ' + beer.name + ' ' + beer.brewery.label;
        return beerTitle.toLowerCase().includes(this.search.toLowerCase());
      })
    }
  }
};

// Add a Beer
const AddBeer = {
  template: '#add-beer',
  data: () => ({
    errors:[],
    beer: [],
    attemptSubmit: false,
    postStatus: false,
    breweryOptions: [],
    glasswareOptions: []
  }),
  mounted() {
    this.populateBreweries();
    this.populateGlassware();
    this.getEditableBeer();
  },
  methods: {
    populateBreweries() {
      axios.get(breweryListJson).then(response => {
        this.breweryOptions = this.format_json_to_options(response.data);
      }).catch(error => {
        console.log(error);
      });
    },
    populateGlassware() {
      axios.get(glasswareListJson).then(response => {
        this.glasswareOptions = this.format_json_to_options(response.data);
      }).catch(error => {
        console.log(error);
      });
    },
    format_json_to_options(data) {
      var options = [];
      $.each(data, function( index, value ) {
        options.push({'id':value.id, 'label':value.name});
      });
      return options;
    },
    getEditableBeer(){
      var beer_id = this.$route.params.id;
      if (!isNaN(beer_id)) {
        axios.post('/get_beer.php', {
          'beer_id': beer_id
        }).then(response => {
          this.beer = response.data.beer;
        }).catch(error => {
          console.log(error)
        });
      }
    },
    validateForm: function (event) {
      this.attemptSubmit = true;
      if (this.beer.name && this.beer.brewery && this.beer.style && this.beer.glassware && this.beer.abv && this.beer.price && this.beer.description) {
        this.onSubmit();
        return true;
      }
      this.errors = [];
      if(!this.beer.name) this.errors.push("Name required.");
      if(!this.beer.brewery) this.errors.push("Brewery required.");
      if(!this.beer.style) this.errors.push("Beer Style required.");
      if(!this.beer.glassware) this.errors.push("Glassware required.");
      if(!this.beer.abv) this.errors.push("ABV required.");
      if(!this.beer.price) this.errors.push("Price required.");
      if(!this.beer.description) this.errors.push("Description required.");
      event.preventDefault();
    },
    onSubmit () {
      console.log('onsubmit');
      axios.post('/insert_beer.php', {
        'beer_id': this.beer.id,
        'name': this.beer.name,
        'brewery_id': this.beer.brewery.id,
        'style': this.beer.style,
        'glassware_id': this.beer.glassware.id,
        'abv': this.beer.abv,
        'price': this.beer.price,
        'description': this.beer.description
      }).then(response => {
        if (response.data.error === false) {
          this.postStatus = true;
        } else {
          console.log('error', response)
        }
      }).catch(error => {
        console.log(error.response);
      });
    },
    startOver () {
      this.attemptSubmit = false;
      this.postStatus = false;
      this.error = [];
      this.beer = [];
    }
  },
};

// Add a Brewery
const AddBrewery = {
  template: '#add-brewery',
  data: () => ({
    errors: [],
    editable_id: false,
    name: '',
    location: '',
    attemptSubmit: false,
    postStatus: false
  }),
  mounted() {
    this.getEditableBrewery();
  },
  methods: {
    getEditableBrewery(){
      this.editable_id = this.$route.params.id;
      if (!isNaN(this.editable_id)) {
        axios.post('/get_brewery.php', {
          'brewery_id': this.editable_id
        }).then(response => {
          this.name = response.data.name;
          this.location = response.data.location;
        }).catch(error => {
          console.log(error)
        });
      }
    },
    validateForm: function (event) {
      this.attemptSubmit = true;
      if (this.name && this.location) {
        this.onSubmit();
        return true;
      }
      this.errors = [];
      if(!this.name) this.errors.push("Brewery Name required.");
      if(!this.location) this.errors.push("Brewery Location required.");
      event.preventDefault();
    },
    onSubmit () {
      axios.post('/insert_brewery.php', {
        'brewery_id': this.editable_id,
        'name': this.name,
        'location': this.location
      }).then(response => {
        if (response.data.error === false) {
          this.postStatus = true;
        } else {
          console.log('error', response.data.error)
        }
      }).catch(error => {
        console.log(error.response)
      });
    },
    startOver () {
      this.attemptSubmit = false;
      this.postStatus = false;
      this.name = '';
      this.location = '';
      this.errors = [];
    }
  },
};

// Create vue router
var router = new VueRouter({
  mode: 'history',
  routes: [
    {
      name: 'BuildMenu',
      path: '/',
      component: BuildMenu
    },
    {
      name: 'AddBeer',
      path: '/add-beer',
      component: AddBeer
    },
    {
      name: 'EditBeer',
      path: '/edit-beer/:id',
      component: AddBeer
    },
    {
      name: 'AddBrewery',
      path: '/add-brewery',
      component: AddBrewery
    },
    {
      name: 'EditBrewery',
      path: '/edit-brewery/:id',
      component: AddBrewery
    },
  ]
});

// Create vue instance and mount onto #app
var vue = new Vue({router});
var app = vue.$mount('#app');