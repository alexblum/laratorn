<template>
    <div>
        <div class="field has-addons">
            <div class="control">
                <input class="input" type="text" v-model.lazy="searchQuery" @keyup.13="doSearch" placeholder="Item name / ID">
            </div>
            <div class="control">
                <button type="submit" :class="['button', 'is-primary', ajaxLoading ? 'is-loading' : '']" @click="doSearch">Search</button>
            </div>
        </div>

        <table class="table is-hoverable is-striped is-fullwidth" id="items" v-if="items.length">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Type</th>
                <th class="pointed" @click="sortItemsBy('buy_price')">Buy price <i v-show="sortedBy === 'buy_price'" :class="['fa', sortedClass]" aria-hidden="true"></i></th>
                <th class="pointed" @click="sortItemsBy('sell_price')">Sell price <i v-show="sortedBy === 'sell_price'" :class="['fa', sortedClass]" aria-hidden="true"></i></th>
                <th class="pointed" @click="sortItemsBy('market_value')">Market value <i v-show="sortedBy === 'market_value'" :class="['fa', sortedClass]" aria-hidden="true"></i></th>
                <th class="pointed" @click="sortItemsBy('circulation')">Circulation <i v-show="sortedBy === 'circulation'" :class="['fa', sortedClass]" aria-hidden="true"></i></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in items">
                <td>{{ item.id }}</td>
                <td>{{ item.name }}</td>
                <td :title="item.description">{{ item.description.length > 70 ? item.description.slice(0, 69) + ' ...' : item.description }}</td>
                <td>{{ item.type }}</td>
                <td class="has-text-right">{{ item.buy_price }}</td>
                <td class="has-text-right">{{ item.sell_price }}</td>
                <td class="has-text-right">{{ item.market_value }}</td>
                <td class="has-text-right">{{ item.circulation }}</td>
            </tr>
            </tbody>
        </table>
        <paginate
                v-if="items.length"
                :page-count="pageCount"
                :click-handler="fetch">
        </paginate>
        <div class="columns" v-else>
            <div class="column has-text-centered"><i class="fa fa-spinner fa-spin" aria-hidden="true"></i></div>
        </div>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                items: [],
                pageCount: 1,
                endpoint: 'api/items/',
                searchQuery: '',
                ajaxLoading: false,
                sortedBy: '',
                sortedOrder: ''
            };
        },

        created() {
            this.fetch();
        },

        computed: {
            sortedClass: function() {
                let result = '';
                if (this.sortedOrder === 'asc') {
                    result = 'fa-sort-alpha-asc';
                } else {
                    result = 'fa-sort-alpha-desc';
                }
                return result;
            }
        },

        methods: {
            fetch(page = 1) {
                this.ajaxLoading = true;
                axios.get(this.endpoint, {params: {page: page}})
                    .then(({data}) => {
                        this.items = data.items.data;
                        this.pageCount = data.items.last_page;
                        this.ajaxLoading = false;
                });
            },

            doSearch() {
                if (this.searchQuery.length) {
                    this.ajaxLoading = true;
                    this.sortedBy = '';
                    this.sortedOrder = '';
                    axios.get(this.endpoint + this.searchQuery)
                        .then(({data}) => {
                            this.items = data.items.data;
                            this.pageCount = data.items.last_page;
                            this.ajaxLoading = false;
                        });
                }
            },

            sortItemsBy(key) {
                this.sortedBy = key;
                this.sortedOrder = this.sortedOrder === 'asc' ? 'desc' : 'asc';
                this.items.sort((o1, o2) => {
                    if (this.sortedOrder === 'asc') {
                        return o1[key] > o2[key] ? 1 : -1;
                    } else {
                        return o1[key] > o2[key] ? -1 : 1;
                    }
                });
            }
        }
    }
</script>

<style lang="css" scoped>
    .pointed {
        cursor: pointer;
    }
</style>
