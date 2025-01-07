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
                WebP Image Converter
            </h1>

            <div 
                class="rounded-lg shadow-md p-8" 
                :class="themeStore.theme === 'light' ? 'bg-white' : 'bg-gray-700'"
            >
                <h2 
                    class="text-2xl font-semibold mb-6" 
                    :class="themeStore.theme === 'light' ? 'text-gray-800' : 'text-gray-100'"
                >
                    Upload WebP Image to Convert
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
                        accept=".webp"
                    />
                    
                    <div v-if="!uploadedFile">
                        <svg 
                            xmlns="http://www.w3.org/2000/svg" 
                            class="sm:h-32 h-16 w-16 mx-auto mb-4" 
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
                            Drag and drop a WebP file or 
                            <span 
                                @click="triggerFileInput" 
                                class="text-blue-500 cursor-pointer hover:underline"
                            >
                                browse
                            </span>
                        </p>
                        
                        <p 
                            class="text-sm mt-2" 
                            :class="themeStore.theme === 'light' ? 'text-gray-500' : 'text-gray-400'"
                        >
                            Supported type: 
                            <span 
                                v-for="(type, index) in supportedInputTypes" 
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
                        />
                    </div>

                    <div>
                        <label 
                            class="block mb-2" 
                            :class="themeStore.theme === 'light' ? 'text-gray-700' : 'text-gray-300'"
                        >
                            Output Format
                        </label>
                        <select 
                            v-model="outputFormat" 
                            class="w-full px-3 py-2 border rounded-md" 
                            :class="[
                                themeStore.theme === 'light' 
                                ? 'border-gray-300 bg-white' 
                                : 'border-gray-700 bg-gray-800 text-white'
                            ]"
                        >
                            <option value="png" selected>PNG</option>
                            <option value="jpg">JPG</option>
                            <option value="jpeg">JPEG</option>
                            <option value="gif">GIF</option>
                        </select>
                    </div>
                </div>

                <div 
                    v-if="previewImage" 
                    class="mt-6 flex justify-center"
                >
                    <img 
                        :src="previewImage" 
                        alt="Image Preview" 
                        class="max-w-full max-h-64 rounded-md shadow-md"
                    />
                </div>

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
                        @click="convertImage" 
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
                        <span v-if="!isConverting">Convert Image</span>
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
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useThemeStore } from '../Stores/Theme'
import { router } from '@inertiajs/vue3'

const themeStore = useThemeStore()

// Define supported input types
const supportedInputTypes = ['.webp']

// State management
const uploadedFile = ref(null)
const isDragOver = ref(false)
const outputFilename = ref('')
const outputFormat = ref('png')
const conversionStatus = ref(null)
const conversionStatusMessage = ref('')
const previewImage = ref(null)

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
    if (supportedInputTypes.includes(fileExtension)) {
        uploadedFile.value = file
        
        // Set output filename without extension
        outputFilename.value = file.name.split('.')[0]

        // Create preview
        const reader = new FileReader()
        reader.onload = (e) => {
            previewImage.value = e.target.result
        }
        reader.readAsDataURL(file)
    } else {
        alert(`Please upload a file with one of these extensions: ${supportedInputTypes.join(', ')}`)
    }
}

const removeFile = () => {
    uploadedFile.value = null
    fileInput.value.value = null
    outputFilename.value = ''
    conversionStatus.value = null
    conversionStatusMessage.value = ''
    previewImage.value = null
}

// Add isConverting state
const isConverting = ref(false)

const convertImage = async () => {
    if (!uploadedFile.value) {
        alert('Please upload a file first')
        return
    }

    const formData = new FormData()
    formData.append('file', uploadedFile.value)
    formData.append('filename', outputFilename.value)
    formData.append('format', outputFormat.value)

    try {
        // Set loading state to true
        isConverting.value = true
        conversionStatus.value = null
        conversionStatusMessage.value = ''

        const response = await axios.post('/image', formData, {
            responseType: 'blob'
        })

        const blob = new Blob([response.data], { type: `image/${outputFormat.value}` })
        const link = document.createElement('a')
        link.href = window.URL.createObjectURL(blob)
        link.download = `${outputFilename.value}.${outputFormat.value}`
        document.body.appendChild(link)
        link.click()
        document.body.removeChild(link)

        conversionStatus.value = 'success'
        conversionStatusMessage.value = `File successfully converted to ${outputFormat.value.toUpperCase()}!`
    } catch (error) {
        conversionStatus.value = 'error'
        conversionStatusMessage.value = 'An error occurred while converting the image'
        console.error('Conversion Error:', error)
    } finally {
        // Set loading state back to false
        isConverting.value = false
    }
}


</script>