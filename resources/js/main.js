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

//var API = 'https://openwhisk.ng.bluemix.net/api/v1/web/rcamden%40us.ibm.com_My%20Space/default/nameSearch.json?search=';


// OLD WORKING METHOD
// searchBeers:function() {
//   if(this.search.length < 3) return;
//   fetch(API + encodeURIComponent(this.search))
//     .then(res => res.json())
//   .then(res => {
//     console.log(res);
//   this.filteredBeers = res.names;
// });


// Base Url of the API
const beerListJson = "resources/data/beers.json";

var app = new Vue({
  el: '#Main',
  data: {
    search: '',
    beers: [],
    activeBeers: [],
    loading: false
  },
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
});