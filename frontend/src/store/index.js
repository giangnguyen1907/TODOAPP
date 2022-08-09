import Vue from "vue";
import Vuex from "vuex";

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    completed: false,
    ttodos:[],
    todos: [],
    textC: '',
    UserID:'',
  },
  getters: {
    UserID: (state) =>state.UserID,
    textC: (state) => state.textC,
    allTodos: (state) => state.todos,
    completed: (state) => state.completed,
  },
  
  actions: {
    changeCompleted({ commit }) {
      commit("change_complete");
    },
    addTodo({ commit }, todo) {
      commit("add_todo", todo);
    },
    deleteTodo({ commit }, id) {
      commit("delete_todo", id);
    },
    
    updateTodo({ commit }, todo) {
      commit("update_todo", todo);
    },
  },
  mutations: {
    add_todo(state, todo) {
      state.todos.push(todo);
      // state.ttodos = state.todos;
    },
    delete_todo(state, id) {
      state.todos = state.todos.filter((todo) => todo.id != id);
      state.ttodos = state.todos;
      
    },
    update_todo(state, todo) {
      let index = state.todos.findIndex((t) => t.id == todo.id);
      if (index != -1) {
        state.todos[index] = todo;
      }
    },
    change_complete(state) {
      state.ttodos = state.todos;
      state.completed = state.completed == true ? false : true;
      state.ttodos = state.ttodos.filter((t) => t.complete == state.completed);
    },
  },
  modules: {},
});