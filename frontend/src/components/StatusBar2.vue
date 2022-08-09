<template>
  <div class='status-container'>
    <div v-bind:class='{ "status-item--selected": filterType === "total", "status-item": true }'>
      <button class='status-number' type='button' value='total' v-on:click='onFilter' >
         {{ allTodos.filter(allTodos => allTodos.user_id === 2 ).length }}
      </button>
      <p class='status-description'>
        Tổng
      </p>
    </div>
    <div v-bind:class='{ "status-item--selected": filterType === "remaining", "status-item": true }'>
      <button class='status-number' type='button' value='remaining' v-on:click='onFilter'>
        {{ allTodos.filter(allTodos => allTodos.user_id === 2 & allTodos.isDone === 0,).length }}
      </button>
      <p class='status-description'>
        Xử lý
      </p>
    </div>
    <div v-bind:class='{ "status-item--selected": filterType === "done", "status-item": true }'>
      <button class='status-number' type='button' value='done' v-on:click='onFilter'>
        {{ allTodos.filter(allTodos => allTodos.isDone === 1 & allTodos.user_id === 2 ).length }}
      </button>
      <p class='status-description'>
        Hoàn Thành
      </p>
    </div>
  </div>
</template>

<script>
  import { isIntegerKey } from '@vue/shared'
import { mapGetters,mapMutations } from 'vuex'
    export default {
        props: {
            // toDoData: {
            //     type: Array,
            //     required: true
            // },
            filterType: {
                type: String,
                required: true
            }
        },
        methods: {
            onFilter(e) {
                this.$emit('onFilter', e.target.value)
            } 
        },
        computed: {
          ...mapGetters(['allTodos']) ,
        }
    }
</script>
