<script setup>
import { onMounted, ref } from 'vue';
import CalculateButton from './buttons/Calculate.vue';
import ResetButton from './buttons/Reset.vue';
import XmlButton from './buttons/Xml.vue';
import SaveButton from './buttons/Save.vue';
import CsvButton from './buttons/Csv.vue';
import Table from './Table.vue';
import Swal from 'sweetalert2';

const initialBudget = ref([]);
let remainderBudget = ref([]);
const currency = ref([]);
const pocketBudgetLimit = ref([]);
let pockets = ref([]);
let pocketValues = ref([]);
let pocketValuesDivided12 = ref([]);
let months = ref([]);

let next = false;
const formData = new FormData();

onMounted(async () => {
    getPlanData();
})

const onNext = () => {
    let result = 0;
    const values = {};

    Object.keys(pocketValues.value).forEach(key => {
        values[key] = pocketValues.value[key];
        result += values[key];
    })

    const tempPocketValuesArray = Object.values(values);
    const isValid = tempPocketValuesArray.every(value => value <= pocketBudgetLimit.value && value > 0) && result <= initialBudget.value;

    if (isValid) {
        pocketValuesDivided12 = tempPocketValuesArray.map(value => (value / 12).toFixed(2));
        formData.append('pockets_budget_annual', tempPocketValuesArray);
        formData.append('pockets_budget_monthly', pocketValuesDivided12);
        remainderBudget.value = initialBudget.value - result;
        next = true;
    } else {
        next = false;
    }
}

const onSave = async () => {
    let response = await axios.post('/save',formData);
    swal(response);
}

const onReset = () => {
    remainderBudget.value = initialBudget.value;
    Object.keys(pocketValues.value).forEach(key => {
        pocketValues.value[key] = 0;
    });
    next = false;
}

const onGenerateXml = async () => {
    let response = await axios.post('/generate_xml',formData);
    swal(response);
}

const onGenerateCsv = async () => {
    let response = await axios.post('/generate_csv',formData);
    swal(response);
}

const getPlanData = async () => {
    let response = await axios.get('/get_plan_data');
    initialBudget.value = response.data.budget;
    remainderBudget.value = initialBudget.value;
    currency.value = response.data.currency;
    pockets.value = response.data.pockets;
    pocketBudgetLimit.value = response.data.pocketBudgetLimit;
    months.value = response.data.months;
}

const swal = (response) => {
    if (response.status === 200) {
      Swal.fire({
        icon: 'success',
        title: response.data.message,
      })
    } else {
      Swal.fire({
        icon: 'error',
        title: response.data.message,
      })
    }
}
</script>

<template>
    <div>
        <div class="d-flex justify-content-center mb-2">
            <h4>Your cafeteria budget:</h4>
        </div>
        <div class="d-flex justify-content-center mb-5">
            <h1>{{ remainderBudget }}{{ currency }}</h1>
        </div>
        <form @submit.prevent="onNext" class="content">
            <div class="mb-4">
                <h4>Your pockets:</h4>
            </div>
            <div class="row mb-4">
                <div class="col" v-for="(value, key) in pockets" :key="key">
                    <div class="d-flex justify-content-center mb-2"><h3>{{ value }}</h3></div>
                    <div class="input-group mb-2">
                        <input
                            type="number" class="form-control"
                            v-model="pocketValues[(key + 1)]"
                            min=0
                            required>
                        <span class="input-group-text" id="currency">{{ currency }}</span>
                    </div>
                    <div class="d-flex justify-content-center mb-2">
                        <span v-show="pocketValues[(key + 1)] > pocketBudgetLimit" style="color: red;">
                            The price is more than {{ pocketBudgetLimit }}{{ currency }}.
                        </span>
                        <span v-show="pocketValues[(key + 1)] <= 0" style="color: red;">
                            The price is less than 1 {{ currency }}.
                        </span>
                    </div>
                </div>
            </div>
            <div v-if="!next" class="d-flex justify-content-center mb-4">
                <CalculateButton />
            </div>
        </form>

        <div v-if="next">
            <div class="d-flex justify-content-center mb-4">
                <ResetButton @click="onReset" />
                <XmlButton @click="onGenerateXml" />
                <CsvButton @click="onGenerateCsv" />
                <SaveButton @click="onSave" />
            </div>
            <div class="d-flex justify-content-center mb-4">
                <Table :pockets="pockets" :months="months" :pocketValues="pocketValuesDivided12" />
            </div>
        </div>
    </div>
</template>