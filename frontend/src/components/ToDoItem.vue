<template>
  <div class='item' v-bind:class='{ "item--done": isDone }'>
    <div class='checkbox'>
      <input
        class='checkbox-input'
        v-bind:id='id'
        v-on:input='completeItem'
        v-bind:value='isDone'
        type='checkbox'
      >
      <label class='checkbox-label' v-bind:for='id'></label>
    </div>
    <div
      class='item-text'
      contenteditable='true'
      v-on:focusout='editItem'
      v-on:keypress='handleKeyPress'
    >
      {{ text }}
    </div>
    <button class='delete-button' v-on:click='deleteItem'></button>
  </div>
</template>
<script>

// import { mapGetters,mapMutations } from 'vuex'

    export default {
        name: 'ToDoItem',
        // computed:{
        //      ...mapGetters(['']) ,
        // }
        props: {
            id: {
                type: String,
                required: true
            },
            text: {
                type: String,
                required: true
            },
            isDone: {
                type: Boolean,
                required: true
            }
        },
        methods: {

            // ...mapMutations(['deleteTodo']),
            deleteItem() {
                this.$emit('onDelete', this.id)
            },
            editItem(e) {
                this.$emit('onEdit', this.id, e.target.innerText)
            },
            completeItem(e) {
                this.$emit('onComplete', this.id, e.target.value === 'false' )
                console.log(e.target.value)
            },
            handleKeyPress(e) {
                if (e.which === 13) {
                    e.preventDefault();
                }
            }
        }
    }
</script>
