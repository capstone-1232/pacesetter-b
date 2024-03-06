new Vue({
    el: '#filtered_posts',
    data: {
        currentFilter: '',
        categories: [],
        posts: [],
        isHidden: true,
    },
    mounted() {
        fetch("nneitling1.dmitstudent.ca/pacesetterski/wp-json/wp/v2/categories")
            .then(response => response.json())
            .then((data) => {
                this.categories = data;
            })
        fetch("pnneitling1.dmitstudent.ca/pacesetterski/wp-json/wp/v2/posts?per_page=20&_embed=wp:term,wp:featuredmedia")
            .then(response => response.json())
            .then((data => {
                this.posts= data;
            }))
    },
    
    methods: {
        setFilter: function (filter) {
            this.currentFilter = filter;
        }
    }
    });