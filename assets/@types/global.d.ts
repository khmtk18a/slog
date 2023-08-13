export { };

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
    user: User
    createAt: string
    updateAt: string
  }
}
