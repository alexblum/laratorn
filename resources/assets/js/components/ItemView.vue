<template>
    <div :class="['modal', {'is-active':doLoadItemData}]">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title">{{item.name}}</p>
                <button class="delete" aria-label="close" @click="close"></button>
            </header>
            <section class="modal-card-body">

                <div class="media" v-if="item.id > 0">
                    <div class="media-left">
                        <figure class="image">
                            <img :src="item.image">
                        </figure>
                    </div>
                    <div class="media-content">
                        <p class="subtitle is-6" v-text="item.description"></p>
                    </div>
                </div>
                <div v-if="item.id > 0">
                    <div class="tabs is-fullwidth is-small">
                      <ul>
                        <li :class="{'is-active': showBazaar === true}"><a @click="showBazaar = true">Bazaar</a></li>
                        <li :class="{'is-active': showBazaar === false}"><a @click="showBazaar = false">Market</a></li>
                      </ul>
                    </div>
                    <table class="table is-hoverable is-striped is-fullwidth" v-show="showBazaar">
                        <tr v-for="bazaar in bazaarItems">
                            <td class="has-text-right">{{bazaar.quantity}}</td>
                            <td class="has-text-right">{{bazaar.cost | currency}}</td>
                        </tr>
                    </table>
                    <table class="table is-hoverable is-striped is-fullwidth" v-show="showBazaar === false">
                        <tr v-for="itemmarket in marketItems">
                            <td class="has-text-right">{{itemmarket.quantity}}</td>
                            <td class="has-text-right">{{itemmarket.cost | currency}}</td>
                        </tr>
                    </table>
                </div>
                <div class="columns" v-else>
                    <div class="column has-text-centered"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
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
                market: [],
                showBazaar: true
            }
        },

        props: {
            itemId: Number,
            show: Boolean
        },

        computed: {
            doLoadItemData: function () {
                if (this.show) {
                    this.loadItem()
                }
                return this.show;
            },
            bazaarItems: function () {
                if (this.market.bazaar !== null) {
                    let items = Object.values(this.market.bazaar);
                    items.sort((a,b) => a.cost - b.cost);
                    return items.slice(0, 9);
                }
                return [];
            },
            marketItems: function () {
                if (this.market.itemmarket !== null) {
                    let items = Object.values(this.market.itemmarket);
                    items.sort((a,b) => a.cost - b.cost);
                    return items.slice(0, 9);
                }
                return [];
            }
        },

        filters: {
            currency: function(value) {
                let formatter = new Intl.NumberFormat('en-US', {
                  style: 'currency',
                  currency: 'USD',
                  minimumFractionDigits: 0
                });
                return formatter.format(value);
            }
        },

        methods: {
            close() {
                this.item = [];
                this.market = [];
                this.$emit('close');
            },

            loadItem() {
                axios.get(this.endpoint + this.itemId)
                    .then(({data}) => {
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
    .media {
        margin-bottom: 5px;
    }
    .media-content {
        overflow: hidden;
    }
</style>

