<template>
    <div>
        <t-modal v-model="showModal">
            <comment />
        </t-modal>
        <button @click="showModal=true" type="button">Show modal</button>
    </div>
</template>

<script>
import Comment from './CommentComponent'
export default {
    components: {
        Comment,
    },
    data() {
        return {
            showModal: false
        }
    }
}
</script>
