<template>
    <div class="mx-auto col-8" id="cafeteriaPerMonth">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th v-for="(pocket, key) in pockets" :key="key">{{ pocket }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(month) in months">
                    <th scope="row">{{ month }}</th>
                    <td v-for="(pocketValue) in pocketValues">{{ pocketValue }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
export default {
  props: {
    pockets: {
      type: Array,
    },
    months: {
      type: Array,
    },
    pocketValues: {
      type: Array,
    },
  }
};
</script>