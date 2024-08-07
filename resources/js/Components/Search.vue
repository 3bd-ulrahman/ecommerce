<script setup lang="jsx">
/** @jsx h */
import { autocomplete, getAlgoliaResults } from '@algolia/autocomplete-js';
import algoliasearch from 'algoliasearch';
import { h, Fragment } from 'preact';
import { onMounted } from 'vue'
import '@algolia/autocomplete-theme-classic';

const searchClient = algoliasearch(
  import.meta.env.VITE_ALGOLIA_APP_ID,
  import.meta.env.VITE_ALGOLIA_SEARCH
);

onMounted(() => {
  autocomplete({
    container: '#autocomplete',
    placeholder: 'Search for products',
    insights: true,
    getSources({ query }) {
      return [
        {
          sourceId: 'products',
          getItems() {
            return getAlgoliaResults({
              searchClient,
              queries: [
                {
                  indexName: 'products',
                  query,
                  params: {
                    hitsPerPage: 5,
                    attributesToSnippet: ['name:10', 'description:35'],
                    snippetEllipsisText: '…',
                  },
                },
              ],
            });
          },
          templates: {
            item({ item, components }) {
              return <ProductItem hit={item} components={components} />;
            },
          },
        },
      ];
    },
  });
});

function ProductItem({ hit, components }) {
  return (
    <a href={route('shop.show', hit.slug )}>
      <div className="aa-ItemWrapper">
        <div className="aa-ItemContent">
          <div className="aa-ItemIcon aa-ItemIcon--alignTop">
            <img src={hit.image} alt={hit.name} width="40" height="40" />
          </div>
          <div className="aa-ItemContentBody">
            <div className="aa-ItemContentTitle">
              <components.Highlight hit={hit} attribute="name" />
            </div>
            <div className="aa-ItemContentDescription">
              <components.Snippet hit={hit} attribute="description" />
            </div>
          </div>
        </div>
      </div>
    </a>
  );
}
</script>

<template>
  <div id="autocomplete"></div>
</template>
