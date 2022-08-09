<template>
  <div class="about">
    <div id="app" class="app">
    
    <div class='app-container'>
      <header class='app-header'>
        <DateBar />
        <StatusBar
          v-bind:UserID=1
          v-bind:to-do-data='allTodos'
          v-bind:filter-type='filterType' 
          @onFilter='onFilter'
        />
      </header>
      <div class='app-body'>
    <div class='text-container'>
    
    <input
      class='input-text'
      placeholder='Add a Task' 
      
      v-model='textContent'
    >
  </div>
        <Search
          @onSearch='onSearch'
        />
         <button class='add-button' v-on:click='onItemAdd'>
          Add a Task
        </button>
        <div class='list'>
          <ToDoItem
            v-for="(allTodos,index) in searchList" :key="index" 
            v-if="allTodos.user_id==1"
            v-bind:id='allTodos.id'
            v-bind:text='allTodos.text'
            v-bind:key='allTodos.id'
            v-bind:is-done='allTodos.isDone'
            @onDelete='onItemDelete'
            @onEdit='onItemEdit'
            @onComplete='onItemComplete'
          />
        </div>
       
      </div>

    </div>
  </div>
  </div>
</template>
<script>
    import { mapGetters,mapMutations } from 'vuex'
    import ToDoItem from '/src/components/ToDoItem'
    import Search from '/src/components/Search'
    import StatusBar from '/src/components/StatusBar'
    import DateBar from '/src/components/DateBar'
    import Helpers from '/src/helpers/helper'
    import '/src/styles/main.scss' 
    import axios from 'axios'

    export default {
        components: {
            DateBar,
            StatusBar,
            ToDoItem,
            Search
        },
        data: () => {
            return {
                filterType: 'total',
                search: '',
                textContent:'',
                // toDoData: [
                    
                // ]
            }
        },
        created(){
        axios.get('http://localhost/app/public/api/index')
        .then(response => {
          this.$store.state.todos=response.data.data
          //this.$store.commit('add_todo',...response.data.data)
          console.log(this.$store.state.todos)
          console.log(response.data.data)
        }) 
        },
        methods: {
            ...mapMutations(['add_todo']),
            ...mapMutations(['delete_todo']),
            ...mapMutations(['update_todo']),
            ...mapMutations(['change_complete']),
            onItemDelete(id) {
                axios.post('http://localhost/app/public/api/remove',{id: id})
                .then(response => {
                  this.$store.state.todos=response.data.data
                })
            },

            onItemAdd() {
               
                let params={ 
                  'id': Helpers.createId(),
                  'text':this.textContent,
                  'isDone': false,
                  'user_id': 1,
                }
                axios.post('http://localhost/app/public/api/add',params)
                .then(response => {
        
                  this.$store.state.todos=response.data.data
                   //store.commit('add_todo',response.data.data)
                })
            },
            onItemEdit(id, text) {
               axios.post('http://localhost/app/public/api/update',{
                id: id,
                text: text,
               })
                .then(response => {
                  this.$store.state.todos=response.data.data
                })
            },
            onItemComplete(id, isDone) {
                // const itemIndex = this.$store.state.todos.findIndex((item) => {
                //     return item.id === id
                // })
                //  this.$store.state.todos[itemIndex].isDone = status
                this.$store.state.todos.isDone = this.$store.state.todos.isDone == true ? false : true;
                axios.post('http://localhost/app/public/api/status',{  
                id: id,
                isDone: this.$store.state.todos.isDone,
               })
                .then(response => {
                  this.$store.state.todos=response.data.data
                  //console.log(this.$store.state.todos) 
                })
            },
            onSearch(value) {
                this.search = value
            },
            onFilter(value) {
                this.filterType = value
            }
        },
        computed: {

              ...mapGetters(['allTodos']) ,
              ...mapGetters(['textC']) ,
              ...mapGetters(['completed']) ,
             // ...mapGetters(['UserID']),
            searchList() {
                return this.filteredList.filter((item) => {
                    return item.text.toLowerCase().includes(this.search.toLowerCase())
                })
            },
            filteredList() {
              let self = this; 
                
                if (this.filterType === 'total') {
                    return this.allTodos
                } else if (this.filterType === 'remaining') {
                    return this.allTodos.filter((item) => {
                        return item.isDone === 0
                    })
                } else {
                    return this.allTodos.filter((item) => {
                        return item.isDone === 1
                    })
                }

            }
        }
    }
</script>
<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}

nav {
  padding: 30px;
}

nav a {
  font-weight: bold;
  color: #2c3e50;
}

nav a.router-link-exact-active {
  color: #42b983;
}
</style>
