<template>
    <div :class="['modal', {'is-active':doLoadItemData}]">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">{{item.name}}</p>
                <button class="delete" aria-label="close" @click="close"></button>
            </header>
            <section class="modal-card-body">
                <!-- Content ... -->
                <div class="media">
                    <div class="media-left">
                        <figure class="image">
                            <img :src="item.image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="title is-4">John Smith</p>
                        <p class="subtitle is-6">@johnsmith</p>
                    </div>
                </div>
            </section>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                endpoint: 'api/item/',
                item: [],
                market: []
            }
        },

        props: {
            itemId: Number,
            show: Boolean
        },

        computed: {
            doLoadItemData: function() {
                if (this.show) {
                    this.loadItem()
                }
                return this.show;
            }
        },

        methods: {
            close() {
                this.$emit('close');
            },

            loadItem() {
                axios.get(this.endpoint + this.itemId)
                    .then(({data}) => {
                        console.log(data);
                        this.item = data.info;
                        this.market = data.market;
                    });
            }
        }



    }
</script>


<style lang="css" scoped>
    .image {
        width: 100px;
    }
</style>

