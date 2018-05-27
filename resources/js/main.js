// var app = new Vue({
//   el: "#Main",
//   data: function() {
//     return {
//       search: '',
//       beers: [
//         { id: '1', name: 'Jhon Snow', profile_pic: 'https://i.stack.imgur.com/CE5lz.png'},
//         { id: '2', name: 'Deanerys Targarian', profile_pic: 'https://i.stack.imgur.com/CE5lz.png'},
//         { id: '3', name: 'Jaime Lanister', profile_pic: 'https://i.stack.imgur.com/CE5lz.png'},
//         { id: '4', name: 'Tyron Lanister', profile_pic: 'https://i.stack.imgur.com/CE5lz.png'}
//       ]};
//   },
//   computed:
//     {
//       filteredBeers:function()
//       {
//         var self = this;
//         return this.beers.filter(function(beer){return beer.name.toLowerCase().indexOf(self.search.toLowerCase())>=0;});
//         //return this.customers;
//       }
//     }
// });

Vue.component('v-select', VueSelect.VueSelect);

// Base Url of the API
const beerListJson = "/resources/data/beers.json";

const BuildMenu = {
  template: '#build-menu',
  data: () => ({
    search: '',
    beers: [],
    activeBeers: [],
    loading: false
  }),
  mounted() {
    this.getBeers();
    this.populateMenu();
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
        this.beers = response.data
        this.loading = false;
      }).catch(error => {
        console.log(error);
      });
    },
    populateMenu() {
      axios.get('get_menu.php').then(response => {
        if (response.data.error) {
          console.log('error', response.data.error)
        } else {
          this.activeBeers = response.data.beers;
          console.log('success', response.data.message)
        }
      }).catch(error => {
        console.log(error.response)
      });
    },
    addBeer(beer) {
      this.activeBeers.push(beer);
      this.updateMenu();
    },
    removeBeer(index) {
      this.activeBeers.splice(index, 1);
      this.updateMenu();
    },
    updateMenu() {
      axios.post('update_menu.php', {
        'activeBeers': this.activeBeers
      }).then(response => {
        if (response.data.error) {
          console.log('error update menu', response.data.error)
        } else {
          console.log('success update menu', response.data.message)
        }
      }).catch(error => {
        console.log(error.response)
      });
    }
  },
  computed: {
    filteredBeers() {
      return this.beers.filter(beer => {
        var beerTitle =  beer.brewery + ' ' + beer.name + ' ' + beer.brewery;
        return beerTitle.toLowerCase().includes(this.search.toLowerCase());
      })
    }
  }
};

// Add a Beer
const AddBeer = {
  template: '#add-beer',
  data: () => ({
    editableBeer: [],
    name: '',
    brewery: '',
    style: '',
    glassware: '',
    abv: '',
    description: '',
    attemptSubmit: false,
    postStatus: false,
    breweryOptions: ['one', 'two', 'three']
  }),
  mounted() {
    this.populateBreweries();
    this.getEditableBeer();
  },
  computed: {
    missingName: function () { return this.name === ''; },
    missingDescription: function () { return this.description === ''; }
    // currentBeer: function() {
    //   var passedID = this.$route.params.id;
    //   var filteredBeers = this.beers.filter(beer => {return beer.id == passedID});
    //   return filteredBeers[0];
    // }
  },
  methods: {
    populateBreweries() {
      axios.get(beerListJson).then(response => {
        this.breweryOptions = ['hi', 'bye'];
      }).catch(error => {
        console.log(error);
      });
    },
    getEditableBeer(){
      var passedID = this.$route.params.id;
      axios.get(beerListJson).then(response => {
        this.editableBeer = response.data[0];
      }).catch(error => {
        console.log(error);
      });
    },
    validateForm: function (event) {
      this.attemptSubmit = true;
      if (this.missingName || this.missingDescription) {
        event.preventDefault();
      } else {
        this.onSubmit();
      }
    },
    onSubmit () {
      axios.post('insert_beer.php', {
        'name': this.name,
        'brewery': this.brewery,
        'style': this.style,
        'glassware': this.glassware,
        'abv': this.abv,
        'description': this.description
      }).then(response => {
        if (response.data.error) {
          console.log('error', response.data.error)
        } else {
          this.postStatus = true;
          console.log('success', response.data.message)
        }
      }).catch(error => {
        console.log(error.response)
      });
    },
    startOver () {
      this.attemptSubmit = false;
      this.postStatus = false;
      this.name = '';
      this.brewery = '';
      this.style = '';
      this.glassware = '';
      this.abv = '';
      this.description = '';
    }
  },
};

// Add a Brewery
const AddBrewery = {
  template: '#add-brewery',
  data: () => ({
    name: '',
    location: '',
    attemptSubmit: false,
    postStatus: false
  }),
  computed: {
    missingName: function () { return this.name === ''; },
    missingLocation: function () { return this.location === ''; }
  },
  methods: {
    validateForm: function (event) {
      this.attemptSubmit = true;
      if (this.missingName || this.missingLocation) {
        event.preventDefault();
      } else {
        this.onSubmit();
      }
    },
    onSubmit () {
      axios.post('insert_brewery.php', {
        'name': this.name,
        'location': this.location
      }).then(response => {
        if (response.data.error) {
          console.log('error', response.data.error)
        } else {
          this.postStatus = true;
          console.log('success', response.data.message)
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
    }
  ]
});

// Create vue instance and mount onto #app
var vue = new Vue({router});
var app = vue.$mount('#app');