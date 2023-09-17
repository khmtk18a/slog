export { }

declare global {
  type User = {
    id: number,
    googleId: string
    name: string
    photo: string
  }
  type Post = {
    id: number
    title: string
    content: string
    score: number
    tags: Tag[]
    user: User
    createAt: string
    updateAt: string
  }
  type Tag = {
    id: number
    name: string
  }
}
