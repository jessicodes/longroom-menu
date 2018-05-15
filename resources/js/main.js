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
  },
  methods: {
    getBeers() {
      this.loading = true;
      axios.get(beerListJson).then(response => {
        this.beers = response.data
      this.loading = false;
    }).catch(error => {
        console.log(error);
    });
    },
    addBeer(beer) {
      this.activeBeers.push(beer);
    },
    removeBeer(index) {
      this.activeBeers.splice(index, 1);
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

// Post component
const AddBeer = {
  template: '#add-beer',
  data: () => ({
    name: '',
    brewery: '',
    style: '',
    glassware: '',
    abv: '',
    description: '',
    attemptSubmit: false,
    postStatus: false
  }),
  computed: {
    missingName: function () { return this.name === ''; },
    missingDescription: function () { return this.description === ''; }
  },
  methods: {
    validateForm: function (event) {
      this.attemptSubmit = true;
      if (this.missingName || this.missingDescription) {
        event.preventDefault();
      } else {
        this.onSubmit();
      }
    },
    onSubmit () {
      axios.post('post.php', {
        'name': this.name,
        'description': this.description
      }).then(response => {
        if (response.data.error) {
          console.log('error', response.data.error)
        } else {
          this.postStatus = true
          console.log('success', response.data.message)
        }
      }).catch(error => {
        console.log(error.response)
      });
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
    }
  ]
});

// Create vue instance and mount onto #app
var vue = new Vue({router});
var app = vue.$mount('#app');