import gql from 'graphql-tag'

export default gql`query posts($count: Int!) {
  posts(count : $count) {
    data {
      id
      title
      slug
      excerpt
      image_url
      media {
        id
        name
        file_name
        full_url
      }
    }
  }
}`
