<template>
  <div 
    class="min-h-screen p-8"
    :class="[
      themeStore.theme === 'light'
        ? 'bg-gray-100 text-gray-900'
        : 'bg-gray-900 text-gray-100'
    ]"
  >
    <div class="container mx-auto max-w-4xl">
      <h1 
        class="text-3xl font-bold mb-8 text-center"
        :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-white'"
      >
        Quiz Maker
      </h1>

      <!-- Stepper Navigation -->
      <div class="flex justify-center mb-8">
        <div class="flex items-center">
          <div 
            v-for="(step, index) in [1, 2, 3]"
            :key="index"
            class="flex items-center"
          >
            <div 
              class="w-10 h-10 rounded-full flex items-center justify-center mr-2"
              :class="[
                currentStep >= step 
                  ? (themeStore.theme === 'light' ? 'bg-blue-500 text-white' : 'bg-blue-700 text-white')
                  : (themeStore.theme === 'light' ? 'bg-gray-300 text-gray-600' : 'bg-gray-700 text-gray-400')
              ]"
            >
              {{ step }}
            </div>
            <div 
              v-if="step < 3"
              class="h-1 w-20"
              :class="[
                currentStep > step
                  ? (themeStore.theme === 'light' ? 'bg-blue-500' : 'bg-blue-700')
                  : (themeStore.theme === 'light' ? 'bg-gray-300' : 'bg-gray-700')
              ]"
            ></div>
          </div>
        </div>
      </div>

      <!-- Step 1: Upload PDF -->
      <div 
        v-if="currentStep === 1" 
        class="rounded-lg shadow-md p-8" 
        :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-700'"
      >
        <h2 
          class="text-2xl font-semibold mb-6" 
          :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-gray-100'"
        >
          Upload File
        </h2>

        <div 
          class="border-2 border-dashed rounded-lg p-8 text-center" 
          :class="[
            isDragOver 
              ? 'border-blue-500 bg-blue-50' 
              : (themeStore.theme === 'light' ? 'border-gray-300 bg-gray-50' : 'border-gray-700 bg-gray-800')
          ]" 
          @dragover.prevent="onDragOver" 
          @dragleave.prevent="onDragLeave" 
          @drop.prevent="onDrop"
        >
          <input 
            type="file" 
            ref="fileInput" 
            @change="onFileChange" 
            class="hidden"
            :accept="supportedFileTypes.join(',')"
          />
          
          <div v-if="!uploadedFile">
            <svg 
              xmlns="http://www.w3.org/2000/svg" 
              class="h-32 w-16 mx-auto mb-4" 
              :class="themeStore.theme === 'light' ? 'text-gray-500' : 'text-gray-400'" 
              fill="none" 
              viewBox="0 0 24 24" 
              stroke="currentColor"
            >
              <path 
                stroke-linecap="round" 
                stroke-linejoin="round" 
                stroke-width="2" 
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" 
              />
            </svg>
            
            <p 
              class="mb-4" 
              :class="themeStore.theme === 'light' ? 'text-gray-600' : 'text-gray-300'"
            >
              Drag and drop a file or 
              <span 
                @click="triggerFileInput" 
                class="text-blue-500 cursor-pointer hover:underline"
              >
                browse
              </span>
            </p>
            
            <p
              class="text-sm"
              :class="themeStore.theme === 'light' ? 'text-gray-500' : 'text-gray-400'"
            >
              Supported files: 
              <span 
                v-for="(type, index) in supportedFileTypes" 
                :key="index" 
                class="inline-block px-2 py-1 m-1 rounded border"
                :class="{
                  'bg-gray-200': themeStore.theme === 'light',
                  'bg-gray-700 border-0': themeStore.theme === 'dark'
                }"
              >
                {{ type.toUpperCase() }}
              </span>
            </p>
          </div>
          
          <div v-else class="flex items-center justify-between">
            <div class="flex items-center">
              <svg 
                xmlns="http://www.w3.org/2000/svg" 
                class="h-8 w-8 mr-4 text-green-500" 
                viewBox="0 0 20 20" 
                fill="currentColor"
              >
                <path 
                  fill-rule="evenodd" 
                  d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" 
                  clip-rule="evenodd" 
                />
              </svg>
              <span>{{ uploadedFile.name }}</span>
            </div>
            <button 
              @click="removeFile" 
              class="text-red-500 hover:text-red-700"
            >
              Remove
            </button>
          </div>
        </div>

        <div class="mt-6 text-right">
          <button 
            @click="nextStep" 
            :disabled="!uploadedFile" 
            class="px-6 py-2 rounded-md transition-colors duration-300" 
            :class="[
              uploadedFile 
                ? (themeStore.theme === 'light' 
                    ? 'bg-blue-500 text-white hover:bg-blue-600' 
                    : 'bg-blue-700 text-white hover:bg-blue-800')
                : 'bg-gray-300 text-gray-500 cursor-not-allowed'
            ]"
          >
            Next
          </button>
        </div>
      </div>

      <!-- Step 2: Configure Questions -->
      <div 
        v-if="currentStep === 2" 
        class="rounded-lg shadow-md p-8" 
        :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-700'"
      >
        <h2 
          class="text-2xl font-semibold mb-6" 
          :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-white'"
        >
          Configure Questions
        </h2>

        <div class="space-y-6">
          <div 
            v-for="(type, index) in questionTypes" 
            :key="index" 
            class="border rounded-lg p-4" 
            :class="themeStore.theme === 'light' ? 'border-gray-200' : 'border-gray-500'"
          >
            <div class="flex items-center justify-between mb-4">
              <h3 
                class="text-lg font-medium" 
                :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-white'"
              >
                {{ type.label }}
              </h3>
              <div class="flex items-center space-x-4">
                <label 
                  class="text-sm" 
                  :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-gray-300'"
                >
                  Number of Questions
                </label>
                <input 
                  type="number" 
                  v-model.number="type.count" 
                  min="0" 
                  max="20" 
                  class="w-20 px-2 py-1 border rounded" 
                  :class="themeStore.theme === 'light' ? 'border-gray-300 bg-white' : 'border-gray-600 bg-gray-800 text-white'"
                />
              </div>
            </div>
          </div>
        </div>

        <div class="mt-6 text-right">
          <button 
            @click="prevStep" 
            class="px-6 py-2 rounded-md transition-colors duration-300" 
            :class="themeStore.theme === 'light' ? 'bg-gray-300 text-gray-500 hover:bg-gray-400' : 'bg-gray-600 text-gray-300 hover:bg-gray-500'"
          >
            Back
          </button>

          <div 
            v-if="isGeneratingQuiz" 
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center"
          >
            <div 
              class="inline-block animate-spin rounded-full h-12 w-12 border-4" 
              :class="themeStore.theme === 'light' 
                ? 'border-blue-500 border-t-transparent' 
                : 'border-blue-700 border-t-transparent'"
            ></div>
            <p 
              class="mt-4 font-semibold"
              :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
            >
              Generating your quiz...
            </p>
          </div>

          <button 
            @click="generateQuiz" 
            class="ml-4 px-6 py-2 rounded-md transition-colors duration-300" 
            :disabled="isGeneratingQuiz"
            :class="themeStore.theme === 'light' 
              ? (isGeneratingQuiz ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-500 text-white hover:bg-blue-600') 
              : (isGeneratingQuiz ? 'bg-gray-700 text-gray-400 cursor-not-allowed' : 'bg-blue-700 text-white hover:bg-blue-800')"
          >
            <span v-if="!isGeneratingQuiz">Generate Quiz</span>
            <span v-else>
              Generating...
            </span>
          </button>

        </div>
      </div>

      <!-- Step 3: Preview Quiz -->
      <div 
        v-if="currentStep === 3" 
        class="rounded-lg shadow-md p-8" 
        :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-700'"
      >
        <h2 
          class="text-2xl font-semibold mb-6" 
          :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-gray-100'"
        >
          Preview Quiz
        </h2>

        <div 
          v-if="questions.length > 0" 
          :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-gray-100'"
        >
          <!-- Display Questions -->
          <div 
            v-for="(question, index) in questions" 
            :key="index" 
            class="mb-6 p-4 border rounded-lg"
          >
            <p 
              class="font-semibold mb-2" 
              :class="themeStore.theme === 'light' ? 'text-gray-900' : 'text-gray-200'"
            >
              {{ question.text }}
            </p>
            <div v-if="question.type === 'multiple_choice'">
              <ul class="space-y-2">
                <li 
                  v-for="(option, i) in question.options" 
                  :key="i" 
                  class="text-sm"
                >
                  {{ option }}
                </li>
              </ul>
            </div>

            <div v-if="question.type === 'true_or_false'">
              <p>{{ question.text }}</p>
              <div>
                <label>
                  <input 
                    type="radio" 
                    :name="'question_' + index" 
                    value="True" 
                  />
                  True
                </label>
                <label>
                  <input 
                    type="radio" 
                    :name="'question_' + index" 
                    value="False" 
                  />
                  False
                </label>
              </div>
            </div>
          </div>

          <!-- Display Answer Key -->
          <div class="mt-8">
            <h3 
              class="text-xl font-semibold mb-4" 
              :class="themeStore.theme === 'light' ? 'text-gray-900' : 'text-gray-100'"
            >
              Answer Key:
            </h3>
            <ul class="space-y-2">
              <li 
                v-for="(answer, index) in answerKey" 
                :key="index" 
                class="text-sm"
              >
                <strong>{{ index + 1 }}.)</strong> {{ answer }}
              </li>
            </ul>
          </div>
        </div>

        <div v-else>
          <p 
            class="text-center text-gray-500" 
            :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
          >
            No questions available for preview. Please make sure you've added questions.
          </p>
        </div>

        <div class="mt-6 text-right">
          <button 
            @click="prevStep" 
            class="px-6 py-2 rounded-md transition-colors duration-300" 
            :class="themeStore.theme === 'light' ? 'bg-gray-300 text-gray-500 hover:bg-gray-400' : 'bg-gray-600 text-gray-300 hover:bg-gray-500'"
          >
            Back
          </button>

          <div 
            v-if="isDownloading" 
            class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center"
          >
            <div 
              class="inline-block animate-spin rounded-full h-12 w-12 border-4" 
              :class="themeStore.theme === 'light' 
                ? 'border-blue-500 border-t-transparent' 
                : 'border-blue-700 border-t-transparent'"
            ></div>
            <p 
              class="mt-4 font-semibold"
              :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
            >
              Downloading your PDF...
            </p>
          </div>

          <button 
            @click="downloadPdf" 
            class="ml-4 px-6 py-2 rounded-md transition-colors duration-300" 
            :disabled="isDownloading"
            :class="themeStore.theme === 'light' 
              ? (isDownloading ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-500 text-white hover:bg-blue-600') 
              : (isDownloading ? 'bg-gray-700 text-gray-400 cursor-not-allowed' : 'bg-blue-700 text-white hover:bg-blue-800')"
          >
            <span v-if="!isDownloading">Download PDF</span>
            <span v-else>
              Downloading...
            </span>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from 'vue'
import { useThemeStore } from '../Stores/Theme'
import { useForm, usePage } from '@inertiajs/vue3'

const themeStore = useThemeStore()
const currentStep = ref(1)
const uploadedFile = ref(null)
const isDragOver = ref(false)
const previewFile = ref(null)
const outputFilename = ref('')
const questionTypes = ref([
  { label: 'Multiple Choice', count: 0 },
  { label: 'True or False', count: 0 },
  { label: 'Short Answer', count: 0 },
])
const questions = ref([])
const answerKey = ref([]) // This will hold the answer key

// Supported file types
const supportedFileTypes = [
  '.pdf', '.docx', '.txt'
]

// Create an Inertia form for quiz generation
const quizForm = useForm({
  file: null,
  questionTypes: [],
})

// Access Inertia props
const page = usePage()

// Watch for updates to the Inertia props to update the questions and answers
watch(() => page.props.questions, (newQuestions) => {
  if (newQuestions) {
    questions.value = newQuestions
    generateAnswerKey(newQuestions)
    nextStep()
  }
})

const generateAnswerKey = (questions) => {
  answerKey.value = questions.map((question, index) => {
    return `${question.answer}`
  })
}

const nextStep = () => {
  if (currentStep.value < 3) {
    currentStep.value++
  }
}

const prevStep = () => {
  if (currentStep.value > 1) {
    currentStep.value--
  }
}

const triggerFileInput = () => {
  document.querySelector('input[type="file"]').click()
}

// Handle file upload and validation
const handleFileUpload = (file) => {
  // Validate file type
  const fileExtension = '.' + file.name.split('.').pop().toLowerCase()
  if (supportedFileTypes.includes(fileExtension)) {
    uploadedFile.value = file
    
    // Auto-generate output filename
    outputFilename.value = file.name.split('.')[0]
  } else {
    alert('Unsupported file type. Please upload a supported file format.')
  }
}

const onFileChange = (event) => {
  const file = event.target.files[0]
  if (file) {
    handleFileUpload(file)
  }
}

const onDragOver = (event) => {
  isDragOver.value = true
}

const onDragLeave = (event) => {
  isDragOver.value = false
}

const onDrop = (event) => {
  isDragOver.value = false
  const file = event.dataTransfer.files[0]
  if (file) {
    // Get the file extension
    const fileExtension = '.' + file.name.split('.').pop().toLowerCase()
    
    // Check if the file type is supported
    if (supportedFileTypes.includes(fileExtension)) {
      handleFileUpload(file)
    } else {
      // Show an error message for unsupported file type
      alert(`Unsupported file type. Please upload a file with one of these extensions: ${supportedFileTypes.join(', ')}`)
    }
  }
}

const previewPdf = () => {
  const reader = new FileReader()
  reader.onload = () => {
    previewFile.value = reader.result
  }
  reader.readAsDataURL(uploadedFile.value)
}

const removeFile = () => {
  uploadedFile.value = null
  previewFile.value = null
}

const isGeneratingQuiz = ref(false);

const generateQuiz = () => {
  if (!uploadedFile.value) return;

  isGeneratingQuiz.value = true; // Start loading screen

  quizForm.file = uploadedFile.value;
  quizForm.questionTypes = questionTypes.value.map(type => ({
    label: type.label,
    count: type.count,
  }));

  quizForm.post('/quiz', {
    onError: (errors) => {
      console.error('Quiz generation failed', errors);
      isGeneratingQuiz.value = false; // Stop loading screen on error
    },
    onFinish: () => {
      isGeneratingQuiz.value = false; // Stop loading screen on success
    },
  });
};

const isDownloading = ref(false);  // Set downloading state to true

const downloadPdf = async () => {
  isDownloading.value = true;  // Set downloading state to true

  try {
    const response = await axios.post('/quiz/download-pdf', {
      questions: questions.value
    }, { responseType: 'blob' });

    const blob = new Blob([response.data], { type: 'application/pdf' });
    const link = document.createElement('a');
    link.href = window.URL.createObjectURL(blob);
    link.download = 'quiz-prompt.pdf';
    
    // Trigger download
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);

  } catch (error) {
    console.error('Failed to download PDF:', error);
  } finally {
    isDownloading.value = false;  // Reset downloading state
  }
};

</script>

<style scoped>
/* Styles for the stepper and other UI elements */
</style>