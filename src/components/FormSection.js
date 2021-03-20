import React from 'react'
import styled from 'styled-components'
import QuestionContainer from './QuestionContainer'

const demoQuestion = [
 {
  question: 'Question One',
  items: ['น้อยมาก', 'น้อย', 'ปานกลาง', 'มาก', 'มากที่สุด'],
 },
 {
  question: 'Question Two',
  items: ['น้อยมาก', 'น้อย', 'ปานกลาง', 'มาก', 'มากที่สุด'],
 },
]

const QuestionSection = styled.section`
 padding: 10px;
`
const QuestionIndividual = () => {
 //  const { question, items } = demoQuestion
 return demoQuestion.map((data) => {
  return (
   <QuestionContainer
    key={data.question}
    question={data.question}
    items={data.items}
   />
  )
 })
}

export default function FormSection() {
 return (
  <QuestionSection>
   <QuestionIndividual />
  </QuestionSection>
 )
}
