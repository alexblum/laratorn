<template>
    <div>
        <table class="table is-hoverable is-striped is-fullwidth" id="items" v-if="items.length">
            <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Type</th>
                <th>Buy price</th>
                <th>Sell price</th>
                <th>Market value</th>
                <th>Circulation</th>
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
                endpoint: 'api/items?page='
            };
        },

        created() {
            this.fetch();
        },

        methods: {
            fetch(page = 1) {
                axios.get(this.endpoint + page)
                    .then(({data}) => {
                        this.items = data.items.data;
                        this.pageCount = data.items.last_page;
                });
            }
        }
    }
</script>
