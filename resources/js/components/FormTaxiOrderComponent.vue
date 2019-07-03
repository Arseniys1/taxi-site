<template>
    <div id="form-taxi-order">
        <form>
            <div class="form-group">
                <label for="from">Откуда</label>
                <input type="text" class="form-control" id="from" placeholder="Откуда">
            </div>
            <div class="form-group">
                <label for="to">Куда</label>
                <input type="text" class="form-control" id="to" placeholder="Куда">
            </div>
            <div class="form-group">
                <label for="phone">Номер телефона</label>
                <input type="text" class="form-control" id="phone" placeholder="Номер телефона">
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="delivery">
                <label class="form-check-label" for="delivery">Доставка</label>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="children">
                <label class="form-check-label" for="children">Дети</label>
            </div>
            <div class="form-group">
                <label for="comment">Комментарий к заказу</label>
                <textarea class="form-control" style="resize: none" id="comment" rows="5"></textarea>
            </div>
            <button type="submit" class="btn btn-dark">Заказать</button>
        </form>
    </div>
</template>

<script>
    export default {
        name: "FormTaxiOrderComponent",

        created() {
            window._form_taxi_order = this;
        },
    }
</script>

<style scoped>

</style>