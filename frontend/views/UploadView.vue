<script setup>
import { onMounted, computed, ref, nextTick } from "vue";
import { useVuelidate } from "@vuelidate/core";
import { required, minLength } from "@vuelidate/validators";
import { toast } from "vue3-toastify";
import { storeToRefs } from "pinia";

import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import { useLSidebarStore } from "../stores/lSidebar";
import { useArticleStore } from "../stores/article";
import { useTagStore } from "../stores/tag";

onMounted(() => {
  ClassicEditor.create(document.querySelector("#editor"), {
    ckfinder: {
      uploadUrl: "http://192.168.1.16:3000/upload",
      baseUrl: "http://192.168.1.16:3000",
    },
  })
    .then((newEditor) => {
      window.editor = newEditor;
      if (articleStore.editArticle) {
        articleTitle.value = articleStore.editArticle.title;
        tags.value = articleStore.editArticle.tags;
        newEditor.setData(articleStore.editArticle.content);
        handleSetPadding();
      }
    })
    .catch((error) => {
      console.error(error);
    });
});

const lSidebarStore = useLSidebarStore();
const articleStore = useArticleStore();
const tagStore = useTagStore();

const articleTitle = ref();

const overlayVisible = ref(false);

const tags = ref([]);
const tagInputRef = ref();
const tagInputValue = ref("");
const tagsRef = ref();
const { tags: existedTags } = storeToRefs(lSidebarStore);

const articleRules = computed(() => {
  return {
    articleTitle: {
      required,
      minLength: minLength(1),
    },
    tags: {
      required,
      noEmptyArray(value) {
        return value.length !== 0;
      },
    },
  };
});
const $v1 = useVuelidate(articleRules, { articleTitle, tags });

if (lSidebarStore.status != "admin-view") {
  lSidebarStore.initAdminView();
  tagStore.fetchTags();
}

async function handleUpload() {
  const isValid = await $v1.value.$validate();
  if (isValid) {
    const contentSize = document.getElementsByClassName(
      "ck-editor__editable",
    )[0].offsetHeight;
    const articleData = {
      title: articleTitle.value,
      tags: tags.value.map((e) => e),
      content: window.editor.getData(),
      toHide: contentSize > 280 ? true : false,
    };
    console.log(articleData);
  }
}

async function handleAddTag(newTag) {
  if (newTag) {
    tags.value.push(newTag);
    tagInputValue.value = "";
    tagInputRef.value.blur();
    handleSetPadding();
  } else {
    if (
      !tags.value.includes(tagInputValue.value) &&
      tagInputValue.value.length > 0
    ) {
      if (existedTags.value.includes(tagInputValue.value)) {
        tags.value.push(tagInputValue.value);
        tagInputValue.value = "";
        tagInputRef.value.blur();
        handleSetPadding();
      } else {
        handleInitTag();
      }
    }
  }
}

async function handleInitTag() {
  overlayVisible.value = true;
  setTimeout(() => {
    const randomBoolean = Math.random() < 0.5;
    if (randomBoolean) {
      tags.value.push(tagInputValue.value);
      existedTags.value.push({ name: tagInputValue.value });
      toast.success("Tạo thể loại mới thành công", { autoClose: 2000 });
    } else {
      toast.error("Tạo thể loại mới thất bại", { autoClose: 2000 });
    }
    tagInputValue.value = "";
    tagInputRef.value.blur();
    handleSetPadding();
    overlayVisible.value = false;
  }, 2000);
}

function handleRemoveTag(removeTag) {
  tags.value = tags.value.filter((tag) => tag != removeTag);
  handleSetPadding();
}

async function handleSetPadding() {
  await nextTick();
  let paddingSize;
  if (tags.value.length == 0) {
    paddingSize = 14;
  } else {
    paddingSize = tagsRef.value.offsetWidth;
  }
  tagInputRef.value.style.setProperty(
    "padding-left",
    `${paddingSize}px`,
    "important",
  );
}
</script>

<template>
  <div
    class="fixed left-0 top-0 z-[50] flex h-[100vh] w-[100vw] lg:left-[20rem] lg:w-[calc(100vw-20rem)] bg-overlay-color"
    v-if="overlayVisible">
    <span class="m-auto block">
      <i class="pi pi-spin pi-spinner text-[4rem]"></i>
    </span>
  </div>
  <div class="w-full p-[1rem] pr-[2rem]">
    <div class="w-auto">
      <span class="mb-[0.25rem] block text-[1.2rem] font-semibold leading-none text-title-text-color">Tiêu đề</span>
      <input v-model="articleTitle" type="text"
        class="w-full rounded-[0.5rem] border-[2px] border-border-color py-[0.75rem] pl-[1rem] text-[1rem] text-title-text-color outline-normal-btn-active"
        :class="{ 'border-error-color': $v1.articleTitle.$error }" />
    </div>
    <div class="relative my-[0.5rem] w-auto">
      <span class="mb-[0.25rem] block text-[1.2rem] font-semibold leading-none text-title-text-color">Thể loại</span>
      <input ref="tagInputRef" v-model="tagInputValue" type="text" @keypress.enter="handleAddTag()"
        class="tag-input w-full rounded-[0.5rem] border-[2px] border-border-color py-[0.75rem] pl-[1rem] text-[1rem] text-title-text-color outline-normal-btn-active"
        @click="(event) => event.target.focus()" :class="{ 'border-error-color outline-error-color': $v1.tags.$error }" />

      <div class="tag-box absolute z-[10] max-h-[15rem] w-full overflow-y-auto bg-green-50 shadow-md">
        <ul>
          <li v-for="tag in existedTags">
            <button
              class="block w-full px-[1rem] py-[0.5rem] text-left text-[1rem] text-normal-text-color hover:bg-normal-btn-hover active:bg-normal-btn-active disabled:bg-normal-btn-hover"
              @click="handleAddTag(tag.name)" v-if="tag.name.includes(tagInputValue) && !tags.includes(tag.name)
                ">
              {{ tag.name }}
            </button>
          </li>
        </ul>
      </div>
      <div class="relative w-full">
        <div class="absolute bottom-[0.5rem] flex pl-[0.5rem]" ref="tagsRef">
          <template v-for="tag in tags">
            <span class="text-ntext mx-[0.25rem] flex items-center rounded-[1rem] bg-green-100 pl-[1rem]">
              <span>
                {{ tag }}
              </span>
              <button @click="handleRemoveTag(tag)"
                class="text-ntext ml-[0.25rem] flex rounded-[1rem] p-[0.5rem] hover:bg-red-500">
                <i class="pi pi-icons pi-times-circle my-auto"></i>
              </button>
            </span>
          </template>
        </div>
      </div>
    </div>
    <div class="w-auto">
      <span class="mb-[0.25rem] block text-[1.2rem] font-semibold leading-none text-title-text-color">Nội dung</span>
      <div id="editor"></div>
    </div>

    <button
      class="mt-[0.5rem] w-full rounded-[0.5rem] bg-normal-btn-bg py-[0.5rem] text-[1.2rem] font-semibold text-normal-text-color hover:bg-normal-btn-hover active:bg-normal-btn-active"
      @click="handleUpload">
      Tải lên
    </button>
  </div>
</template>

<style>
.tag-input:focus+.tag-box {
  display: block !important;
}

.tag-box {
  display: none;
}

.tag-box:hover {
  display: block;
}
</style>
