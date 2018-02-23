<template>
    <nav class="pagination is-right" role="navigation" aria-label="pagination" v-show="shouldShow()">
        <a @click="prevPage()" class="pagination-previous" :disabled="firstPageSelected()">Previous</a>
        <a @click="nextPage()" class="pagination-next" :disabled="lastPageSelected()">Next page</a>

        <ul class="pagination-list">
            <li v-for="page in pages">
                <span v-if="page.disabled" class="pagination-ellipsis">&hellip;</span>
                <a v-else @click="handlePageSelected(page.index)" :class="['pagination-link', page.selected ? 'is-current' : '']">{{ page.content }}</a>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props: {
            pageCount: {
                type: Number,
                required: true
            },
            initialPage: {
                type: Number,
                default: 0
            },
            forcePage: {
                type: Number
            },
            clickHandler: {
                type: Function,
                default: () => {
                }
            },
            pageRange: {
                type: Number,
                default: 3
            },
            marginPages: {
                type: Number,
                default: 1
            }
        },
        data() {
            return {
                selected: this.initialPage
            }
        },
        beforeUpdate() {
            if (this.forcePage === undefined) return
            if (this.forcePage !== this.selected) {
                this.selected = this.forcePage
            }
        },
        computed: {
            pages: function () {
                let items = {}
                if (this.pageCount <= this.pageRange) {
                    for (let index = 0; index < this.pageCount; index++) {
                        let page = {
                            index: index,
                            content: index + 1,
                            selected: index === this.selected
                        }
                        items[index] = page
                    }
                } else {
                    let leftPart = this.pageRange / 2
                    let rightPart = this.pageRange - leftPart

                    if (this.selected < leftPart) {
                        leftPart = this.selected
                        rightPart = this.pageRange - leftPart
                    } else if (this.selected > this.pageCount - this.pageRange / 2) {
                        rightPart = this.pageCount - this.selected
                        leftPart = this.pageRange - rightPart
                    }

                    let setPageItem = index => {
                        let page = {
                            index: index,
                            content: index + 1,
                            selected: index === this.selected
                        }

                        items[index] = page
                    }

                    let setBreakView = index => {
                        let breakView = {
                            content: '...',
                            disabled: true
                        }

                        items[index] = breakView
                    }

                    // 1st - loop thru low end of margin pages
                    for (let i = 0; i < this.marginPages; i++) {
                        setPageItem(i);
                    }

                    // 2nd - loop thru selected range
                    let selectedRangeLow = 0;
                    if (this.selected - this.pageRange > 0) {
                        selectedRangeLow = this.selected - this.pageRange;
                    }

                    // 3rd - loop thru high end of margin pages
                    let selectedRangeHigh = this.pageCount;
                    if (this.selected + this.pageRange < this.pageCount) {
                        selectedRangeHigh = this.selected + this.pageRange;
                    }

                    for (let i = selectedRangeLow; i <= selectedRangeHigh && i <= this.pageCount - 1; i++) {
                        setPageItem(i);
                    }

                    // Check if there is breakView in the left of selected range
                    if (selectedRangeLow > this.marginPages) {
                        setBreakView(selectedRangeLow - 1)
                    }

                    // Check if there is breakView in the right of selected range
                    if (selectedRangeHigh + 1 < this.pageCount - this.marginPages) {
                        setBreakView(selectedRangeHigh + 1)
                    }
                    // 2nd - loop thru high end of margin pages
                    for (let i = this.pageCount - 1; i >= this.pageCount - this.marginPages; i--) {
                        setPageItem(i);
                    }
                }
                return items
            }
        },
        methods: {
            handlePageSelected(selected) {
                if (this.selected === selected) return

                this.selected = selected

                this.clickHandler(this.selected + 1)
            },
            prevPage() {
                if (this.selected <= 0) return

                this.selected--

                this.clickHandler(this.selected + 1)
            },
            nextPage() {
                if (this.selected >= this.pageCount - 1) return

                this.selected++

                this.clickHandler(this.selected + 1)
            },
            firstPageSelected() {
                return this.selected === 0
            },
            lastPageSelected() {
                return (this.selected === this.pageCount - 1) || (this.pageCount === 0)
            },
            selectFirstPage() {
                this.selected = 0

                this.clickHandler(this.selected)
            },
            selectLastPage() {
                this.selected = this.pageCount - 1

                this.clickHandler(this.selected)
            },
            shouldShow() {
                return this.pageCount > 1
            }
        }
    }
</script>

<style lang="css" scoped>
    a {
        cursor: pointer;
    }
</style>
