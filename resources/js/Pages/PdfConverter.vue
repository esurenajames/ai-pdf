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
            File to PDF Converter
        </h1>

        <form 
            @submit.prevent="convertToPDF" 
            class="rounded-lg shadow-md p-8" 
            :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-700'"
        >
            <h2 
            class="text-2xl font-semibold mb-6" 
            :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-gray-100'"
            >
            Upload File to Convert
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
                name="fileToConvert"
                required
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
                type="button"
                @click="removeFile" 
                class="text-red-500 hover:text-red-700"
                >
                Remove
                </button>
            </div>
            </div>

            <div 
            v-if="uploadedFile" 
            class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4"
            >
            <div>
                <label 
                class="block mb-2" 
                :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
                >
                Output Filename
                </label>
                <input 
                v-model="outputFilename" 
                type="text" 
                class="w-full px-3 py-2 border rounded-md" 
                :class="[
                    themeStore.theme === 'light' 
                    ? 'border-gray-300 bg-white' 
                    : 'border-gray-700 bg-gray-800 text-white'
                ]"
                placeholder="Enter output filename"
                name="outputFilename"
                required
                />
            </div>

            <div>
                <label 
                class="block mb-2" 
                :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
                >
                Conversion Settings
                </label>
                <select 
                v-model="conversionSettings" 
                class="w-full px-3 py-2 border rounded-md" 
                :class="[
                    themeStore.theme === 'light' 
                    ? 'border-gray-300 bg-white' 
                    : 'border-gray-700 bg-gray-800 text-white'
                ]"
                name="conversionSettings"
                >
                <option value="default">Default</option>
                <option value="high-quality">High Quality</option>
                <option value="compressed">Compressed</option>
                </select>
            </div>
            </div>

             <!-- Add loading overlay -->
             <div 
                v-if="isConverting" 
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 flex flex-col items-center">
                <div 
                    class="inline-block animate-spin rounded-full h-12 w-12 border-4 border-t-transparent"
                    :class="themeStore.theme === 'light' 
                        ? 'border-blue-500' 
                        : 'border-yellow-400'"
                ></div>
                <p 
                    class="mt-4 font-semibold" 
                    :class="themeStore.theme === 'light' 
                        ? 'text-gray-700' 
                        : 'text-gray-300'"
                >
                    Converting your file...
                </p>
            </div>


            <div class="mt-6 text-right">
                <button 
                    type="submit"
                    :disabled="!uploadedFile || isConverting" 
                    class="px-6 py-2 rounded-md transition-colors duration-300" 
                    :class="[
                        uploadedFile && !isConverting 
                            ? (themeStore.theme === 'light' 
                                ? 'bg-blue-500 text-white hover:bg-blue-600' 
                                : 'bg-blue-700 text-white hover:bg-blue-800')
                            : 'bg-gray-300 text-gray-500 cursor-not-allowed'
                    ]"
                >
                    <span v-if="!isConverting">Convert to PDF</span>
                    <span v-else>Converting...</span>
                </button>
            </div>

            <div 
            v-if="conversionStatus" 
            class="mt-4 p-3 rounded-md" 
            :class="[
                conversionStatus === 'success' 
                ? 'bg-green-100 text-green-800' 
                : 'bg-red-100 text-red-800'
            ]"
            >
            {{ conversionStatusMessage }}
            </div>
        </form>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue'
import { useThemeStore } from '../Stores/Theme';
import { router } from '@inertiajs/vue3';
import axios from 'axios'

const themeStore = useThemeStore()

// Supported file types
const supportedFileTypes = [
    '.docx', '.txt', '.pptx', 'ppt', 
    '.doc', 'html'
]

// State management
const uploadedFile = ref(null)
const isDragOver = ref(false)
const outputFilename = ref('')
const conversionSettings = ref('default')
const conversionStatus = ref(null)
const conversionStatusMessage = ref('')
const fileInput = ref(null)

// File handling methods
const triggerFileInput = () => {
    fileInput.value.click()
}

const onDragOver = () => {
    isDragOver.value = true
}

const onDragLeave = () => {
    isDragOver.value = false
}

const onDrop = (event) => {
    isDragOver.value = false
    handleFileUpload(event.dataTransfer.files[0])
}

const onFileChange = (event) => {
    handleFileUpload(event.target.files[0])
}

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

const removeFile = () => {
    uploadedFile.value = null
    fileInput.value.value = null
    outputFilename.value = ''
    conversionStatus.value = null
    conversionStatusMessage.value = ''
}

// Add isConverting state
const isConverting = ref(false)

const convertToPDF = async () => {
    if (!uploadedFile.value) {
        alert('Please upload a file first')
        return
    }

    const formData = new FormData()
    formData.append('fileToConvert', uploadedFile.value)
    formData.append('outputFilename', outputFilename.value)
    formData.append('conversionSettings', conversionSettings.value)

    try {
        // Set loading state to true
        isConverting.value = true
        conversionStatus.value = null
        conversionStatusMessage.value = ''
        
        const response = await axios.post('/convert', formData, {
            responseType: 'blob'
        })

        const blob = new Blob([response.data], { type: 'application/pdf' })
        const link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = outputFilename.value + '.pdf' 
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)
        
        conversionStatus.value = 'success'
        conversionStatusMessage.value = 'File converted successfully!'
    } catch (error) {
        conversionStatus.value = 'error'
        conversionStatusMessage.value = 'An error occurred while converting the file'
        console.error('Conversion Error:', error)
    } finally {
        // Set loading state back to false
        isConverting.value = false
    }
}

</script>
