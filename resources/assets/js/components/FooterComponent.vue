<template>
    <div>
        <!-- Footer -->
        <footer class="navbar footer-size">
            <br/>
            <hr>
            <div class="text-center">
                <p>Copyright &copy; sre-markt.com {{currentDate}} </p>
            </div>
            <br>
        </footer>
    </div>
</template>

<script>
    import moment from 'moment';
    export default {
        data() {
            return {
                currentDate: moment().format("YYYY")
            }
        },
        mounted() {
        },
        methods: {
        }
    }
</script>